document.addEventListener('DOMContentLoaded', () => {
    const resourceSelect = document.getElementById('resource_type');
    const dateInput = document.getElementById('booking_date');
    const slotsContainer = document.getElementById('slotsContainer');
    const selectedSlotInput = document.getElementById('selected_slot');
    const submitBtn = document.getElementById('submitBtn');
    const bookingForm = document.getElementById('bookingForm');

    const allSlots = ['09:00 - 11:00', '11:00 - 13:00', '13:00 - 15:00', '15:00 - 17:00'];

    // 💡 [แก้ไขจุดบั๊กสำคัญ] ดักจับ Event เฉพาะเมื่อมี Element บนหน้าเพจนั้นจริง ๆ (ป้องกันสคริปต์พังบนหน้า status.php)
    if (resourceSelect && dateInput) {
        [resourceSelect, dateInput].forEach(element => {
            element.addEventListener('change', checkAvailableSlots);
        });
    }

    async function checkAvailableSlots() {
        if (!resourceSelect || !dateInput || !slotsContainer || !selectedSlotInput || !submitBtn) return;

        const resource = resourceSelect.value;
        const date = dateInput.value;

        slotsContainer.innerHTML = '';
        selectedSlotInput.value = '';
        submitBtn.disabled = true;

        if (!resource || !date) {
            slotsContainer.innerHTML = '<p class="info-text">💡 กรุณาเลือกประเภทบริการและวันที่ก่อนเพื่อเช็กคิวว่าง</p>';
            return;
        }

        slotsContainer.innerHTML = '<p class="info-text">⏳ กำลังตรวจสอบคิวว่างจากเซิร์ฟเวอร์...</p>';

        try {
            const formData = new FormData();
            
            // 🗓️ แปลงวันที่จากเบราว์เซอร์ให้เป็นสากล (YYYY-MM-DD) ก่อนส่งไปเช็กคิวว่าง
            let formattedDate = date;
            if (date.includes('/')) {
                let parts = date.split('/');
                let month = parts[0];
                let day = parts[1];
                let year = parseInt(parts[2]);
                if (year > 2500) year -= 543; // แปลง พ.ศ. เป็น ค.ศ.
                formattedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
            } else if (date.includes('-')) {
                let parts = date.split('-');
                if (parts[0] && parseInt(parts[0]) > 2500) {
                    parts[0] = parseInt(parts[0]) - 543; // แปลง พ.ศ. เป็น ค.ศ.
                    formattedDate = parts.join('-');
                }
            }

            formData.append('booking_date', formattedDate);
            formData.append('resource_type', resource);

            const response = await fetch('api/check_slots.php', {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('Server response not ok');
            }
            
            const result = await response.json();

            if (result.error) {
                slotsContainer.innerHTML = `<p class="info-text" style="color: #e53e3e; border-color: #fed7d7;">❌ ${result.error}</p>`;
                return;
            }

            renderSlots(result.booked_slots);

        } catch (error) {
            slotsContainer.innerHTML = '<p class="info-text" style="color: #e53e3e; background: #fff5f5; border-color: #fed7d7; border-style: solid;">❌ ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้ (กรุณาเช็กการเชื่อมต่อฐานข้อมูล)</p>';
        }
    }

    function renderSlots(bookedSlots) {
        if (!slotsContainer || !selectedSlotInput || !submitBtn) return;
        slotsContainer.innerHTML = '';
        const unavailableSlots = bookedSlots || [];
        
        allSlots.forEach(slot => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'slot-btn';
            button.innerText = slot;

            if (unavailableSlots.includes(slot)) {
                button.classList.add('disabled');
                button.disabled = true;
            } else {
                button.addEventListener('click', () => {
                    document.querySelectorAll('.slot-btn').forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    selectedSlotInput.value = slot; 
                    submitBtn.disabled = false;
                });
            }
            slotsContainer.appendChild(button);
        });
    }

    if (bookingForm && submitBtn && dateInput) {
        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.innerText = 'กำลังประมวลผลการจอง...';

            try {
                const formData = new FormData(bookingForm);
                
                let rawDate = dateInput.value;
                if (rawDate.includes('-')) {
                    let parts = rawDate.split('-');
                    if (parts[0] && parseInt(parts[0]) > 2500) {
                        parts[0] = parseInt(parts[0]) - 543;
                        formData.set('booking_date', parts.join('-'));
                    }
                }

                const response = await fetch('api/make_booking.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showSuccessModal(result);
                } else {
                    alert(result.message);
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'ยืนยันข้อมูลการจองคิว';
                    checkAvailableSlots();
                }
            } catch (error) {
                alert('เกิดข้อผิดพลาดทางเทคนิค ไม่สามารถบันทึกข้อมูลได้');
                submitBtn.disabled = false;
                submitBtn.innerText = 'ยืนยันข้อมูลการจองคิว';
            }
        });
    }

    function showSuccessModal(result) {
        const modal = document.getElementById('successModal');
        const summary = document.getElementById('summaryDetails');
        if (!modal || !summary) return;
        
        summary.innerHTML = `
            <p style="text-align:center; border-bottom:1px dashed #bee3f8; padding-bottom:10px; margin-bottom:12px;">
                <strong>รหัสคิวรับบริการของคุณ</strong> <br>
                <span class="highlight-queue" style="font-size: 24px; color: #3182ce; font-weight: bold;">${result.queue_number}</span>
            </p>
            <p style="text-align:center; background:#edf2f7; padding:8px; border-radius:6px; margin-bottom:15px;">
                <strong style="color:#e53e3e;">รหัสคิวลับสำหรับใช้ยกเลิก:</strong> <br>
                <span style="font-size: 20px; font-weight: bold; color: #2d3748;">${result.booking_code}</span>
            </p>
            <p><strong>ผู้จอง:</strong> ${result.data.name} (${result.data.student_id})</p>
            <p><strong>บริการ:</strong> ${result.data.resource}</p>
            <p><strong>วันที่ใช้งาน:</strong> ${result.data.date}</p>
            <p><strong>ช่วงเวลา:</strong> ${result.data.time}</p>
        `;
        
        modal.style.display = 'block';
    }

    const cancelForm = document.getElementById('cancelBookingForm');
    if (cancelForm) {
        cancelForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!confirm('นายแน่ใจใช่ไหมว่าจะทำการยกเลิกคิวจองนี้?')) {
                return;
            }

            const cancelBtn = cancelForm.querySelector('button[type="submit"]');
            cancelBtn.disabled = true;
            cancelBtn.innerText = 'กำลังส่งข้อมูลยกเลิก...';

            try {
                const formData = new FormData(cancelForm);
                const response = await fetch('api/cancel_booking.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                    cancelBtn.disabled = false;
                    cancelBtn.innerText = 'ยืนยันการยกเลิกคิว';
                }
            } catch (error) {
                alert('เกิดข้อผิดพลาดทางระบบ ไม่สามารถส่งคำขอยกเลิกได้');
                cancelBtn.disabled = false;
                cancelBtn.innerText = 'ยืนยันการยกเลิกคิว';
            }
        });
    }

    // =======================================================
    // 📊 4. ฟังก์ชันดึงประวัติการจองมาแสดงผลที่ตารางหน้าบ้านอัตโนมัติ
    // =======================================================
    function loadBookingHistory() {
        const tableBody = document.getElementById('historyTableBody');
        if (!tableBody) return; 

        fetch('api/get_history.php')
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    if (!result.data || result.data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px; color: #1b3322;">🎉 ยังไม่มีข้อมูลการจองคิวในขณะนี้ สามารถเลือกจองได้เลยนาย!</td></tr>`;
                        return;
                    }

                    let rows = '';
                    result.data.forEach(row => {
                        let statusBadge = '';
                        let currentStatus = row.status ? row.status.toLowerCase() : 'pending';

                        if (currentStatus === 'cancelled' || currentStatus === 'canceled') {
                            statusBadge = `<span style="background: #fed7d7; color: #c53030; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">ยกเลิกแล้ว</span>`;
                        } else if (currentStatus === 'checked-in') {
                            statusBadge = `<span style="background: #ebf8ff; color: #2b6cb0; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">เข้าใช้งานแล้ว</span>`;
                        } else if (currentStatus === 'no-show') {
                            statusBadge = `<span style="background: #feebc8; color: #c05621; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">ไม่มาตามนัด</span>`;
                        } else {
                            statusBadge = `<span style="background: #c6f6d5; color: #22543d; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">จองสำเร็จ</span>`;
                        }

                        let hiddenStudentId = row.student_id || '';
                        if (hiddenStudentId.length >= 10) {
                            hiddenStudentId = hiddenStudentId.substring(0, 3) + 'XXXXX' + hiddenStudentId.substring(8);
                        }

                        let displayDate = row.booking_date;
                        if (displayDate && displayDate.includes('-')) {
                            let dParts = displayDate.split('-');
                            displayDate = `${dParts[2]}/${dParts[1]}/${dParts[0]}`;
                        }

                        rows += `
                            <tr style="border-bottom: 1px solid #dfd5c2;">
                                <td style="padding: 14px; font-weight: bold; color: #24422c;">${row.queue_number || '-'}</td>
                                <td style="padding: 14px;">${row.name} (${hiddenStudentId})</td>
                                <td style="padding: 14px;">${row.resource_type || '-'}</td>
                                <td style="padding: 14px; white-space: nowrap;">${displayDate}</td>
                                <td style="padding: 14px; white-space: nowrap;">${row.time_slot}</td>
                                <td style="padding: 14px;">${statusBadge}</td>
                            </tr>
                        `;
                    });
                    tableBody.innerHTML = rows;
                } else {
                    tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px; color: #e53e3e;">❌ ไม่สามารถโหลดข้อมูลได้: ${result.message}</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error loading history:', error);
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px; color: #e53e3e;">❌ ระบบเชื่อมต่อข้อมูลประวัติผิดพลาด</td></tr>`;
            });
        }

    // สั่งรันฟังก์ชันทันทีเมื่อโหลดหน้าเว็บ
    loadBookingHistory();
});