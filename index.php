<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรอกข้อมูลจองคิวเข้าใช้งาน | อ่านได้สบายด้วย</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* 🌌 ปรับปรุงโครงสร้างหน้าเว็บเป็น Dark Mode ทั้งหมด */
        body {
            background-color: #111111 !important; /* พื้นหลังหน้าเว็บเปลี่ยนเป็นสีดำสนิท */
            background-image: none !important; /* เอาภาพพื้นหลังชั้นเดิมออกเพื่อความคลีน */
            color: #ffffff;
            font-family: 'Sarabun', sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-wrapper {
            max-width: 580px;
            margin: 120px auto 60px auto;
            padding: 0 20px;
        }

        /* 🤍 กรอบข้อมูลสีขาว ขอบมน ไม่เหลี่ยม และเรืองแสงด้านหลังเบา ๆ */
        .booking-card {
            background: #ffffff !important;
            color: #1a202c !important;
            border-radius: 24px !important; /* ปรับขอบให้มนโค้ง สวยงาม ไม่เหลี่ยม */
            padding: 40px 35px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.08), 0 10px 25px rgba(0, 0, 0, 0.5); /* พื้นหลังเรืองแสงสีขาวออกมารอบ ๆ แบบนุ่มนวลไม่กระแทกตา */
            border: none !important;
        }

        .form-title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: #1b3322;
            margin-bottom: 8px;
        }

        .form-subtitle {
            text-align: center;
            font-size: 14px;
            color: #718096;
            margin-bottom: 35px;
        }

        .input-group {
            margin-bottom: 22px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        /* 🪟 ช่องกรอกข้อมูลดีไซน์รวมเป็นเนื้อเดียวกับฟอร์มขาว ลดเส้นขอบหนา และเพิ่มเอฟเฟกต์เรืองแสงเมื่อเมาส์ชี้/โฟกัส */
        .form-control-custom {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            font-family: 'Sarabun', sans-serif;
            background-color: #f7fafc; /* ใช้สีเทาอ่อนกลืนไปกับพื้นขาว */
            border: 1px solid #e2e8f0;
            border-radius: 12px; /* ขอบช่องกรอกโค้งมนรับกับตัวฟอร์ม */
            color: #1a202c;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        /* ✨ เอฟเฟกต์เรืองแสงตอนเอาเมาส์ชี้ (Hover) หรือกดคลิก (Focus) เพื่อให้ผู้ใช้รู้ตำแหน่งชัดเจน */
        .form-control-custom:hover,
        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: #1b3322; /* เปลี่ยนขอบเป็นสีเขียวประจำธีม */
            box-shadow: 0 0 10px rgba(27, 51, 34, 0.15); /* เรืองแสงสีเขียวเข้มอ่อน ๆ รอบช่องกรอก */
            outline: none;
        }

        /* 🎯 ส่วนแสดงรอบเวลา */
        .slots-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-top: 25px;
            margin-bottom: 12px;
        }

        /* 🔘 ปุ่มกดยืนยันข้อมูลการจองสีขาว เด่นแยกชั้นไม่กลืนไปกับฟอร์ม */
        .btn-submit-white {
            width: 100%;
            padding: 16px;
            background: #ffffff;
            color: #1b3322;
            border: 2px solid #1b3322; /* มีขอบสีเขียวเพื่อให้มีมิติแยกจากพื้นหลังการ์ดขาว */
            font-size: 16px;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
            margin-top: 30px;
        }

        .btn-submit-white:hover {
            background: #1b3322; /* ชี้แล้วเปลี่ยนสีสลับกันเพื่อความพรีเมียม */
            color: #ffffff;
            box-shadow: 0 6px 15px rgba(27, 51, 34, 0.3);
            transform: translateY(-2px);
        }

        .btn-submit-white:disabled {
            background: #e2e8f0;
            color: #a0aec0;
            border-color: #cbd5e0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ปุ่มลิงก์หน้ายกเลิกด้านล่าง */
        .cancel-link-container {
            text-align: center;
            margin-top: 25px;
            border-top: 1px dashed #e2e8f0;
            padding-top: 20px;
        }

        .btn-to-cancel {
            color: #e53e3e;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-to-cancel:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header class="main-header" style="position: absolute; top: 0; left: 0; width: 100%; box-sizing: border-box;">
        <div class="header-container">
            <div class="brand-logo" onclick="location.href='home.php'" style="cursor: pointer;">
                <span class="logo-icon">🌿</span>
                <span class="brand-name" style="color: #1b3322;">อ่านได้สบายด้วย</span>
            </div>
            <nav class="header-nav" style="display: flex; align-items: center; gap: 20px;">
                <a href="status.php" style="text-decoration: none; color: #1b3322; font-weight: bold; background: #f3ede0; padding: 8px 16px; border-radius: 6px; font-size: 14px;">📊 สถานะจองคิว</a>
                <span class="status-indicator">● ONLINE</span>
            </nav>
        </div>
    </header>

    <div class="form-wrapper">
        <div class="booking-card">
            <h3 class="form-title">กรอกข้อมูลจองคิวเข้าใช้งาน</h3>
            <p class="form-subtitle">กรุณากรอกข้อมูลในช่องด้านล่างนี้ให้ครบถ้วน</p>

            <form id="bookingForm">
                <div class="input-group">
                    <label for="student_id">รหัสนักศึกษา / รหัสสมาชิก</label>
                    <input type="text" id="student_id" name="student_id" class="form-control-custom" placeholder="ระบุรหัสนักศึกษา 10 หลัก" required maxlength="10">
                </div>

                <div class="input-group">
                    <label for="name">ชื่อ - นามสกุล</label>
                    <input type="text" id="name" name="name" class="form-control-custom" placeholder="ชื่อ และ นามสกุล" required>
                </div>

                <div class="input-group">
                    <label for="phone">เบอร์โทรศัพท์</label>
                    <input type="tel" id="phone" name="phone" class="form-control-custom" placeholder="เช่น 0812345678" required maxlength="10">
                </div>

                <div class="input-group">
                    <label for="resource_type">ประเภทบริการที่ต้องการจอง</label>
                    <select id="resource_type" name="resource_type" class="form-control-custom" required>
                        <option value="" disabled selected>-- คลิกเพื่อเลือกบริการ --</option>
                        <option value="ห้อง Smart Silent Zone">ห้อง Smart Silent Zone (เน้นความเงียบ)</option>
                        <option value="ห้อง Creative Lounge">ห้อง Creative Lounge (ทำงานกลุ่ม)</option>
                        <option value="ห้อง Media & Private Box">ห้อง Media & Private Box (มุมส่วนตัว)</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="booking_date">วันที่ต้องการเข้าใช้บริการ</label>
                    <input type="date" id="booking_date" name="booking_date" class="form-control-custom" required>
                </div>

                <div class="slots-section-title">🔮 รอบเวลาที่ต้องการ (รอบละ 2 ชั่วโมง)</div>
                <div id="slotsContainer">
                    <p class="info-text" style="color: #718096; text-align: center; padding: 15px; background: #f7fafc; border-radius: 12px; font-size: 14px; margin: 0;">
                        💡 กรุณาเลือกประเภทบริการและวันที่ด้านบนก่อนเพื่อเช็กคิวว่าง
                    </p>
                </div>

                <input type="hidden" id="selected_slot" name="time_slot" required>

                <button type="submit" id="submitBtn" class="btn-submit-white" disabled>
                    ยืนยันข้อมูลการจองคิว
                </button>
            </form>

            <div class="cancel-link-container">
                <a href="cancel.php" class="btn-to-cancel">
                    หากต้องการยกเลิกคิวที่จองไว้แล้ว? คลิกที่นี่
                </a>
            </div>
        </div>
    </div>

    <div id="successModal" class="modal" style="display:none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); overflow: auto;">
        <div class="modal-content" style="background-color: #ffffff; color: #1a202c; margin: 10% auto; padding: 30px; border-radius: 20px; max-width: 480px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); font-family: 'Sarabun', sans-serif;">
            <div style="text-align: center; font-size: 45px; margin-bottom: 10px;">🎉</div>
            <h3 style="text-align: center; margin: 0 0 20px 0; font-size: 22px; color: #1b3322; font-weight: 700;">การจองคิวสำเร็จแล้ว!</h3>
            <div id="summaryDetails" style="font-size: 15px; color: #4a5568; line-height: 1.6;"></div>
            <button onclick="location.href='status.php'" style="width:100%; padding:12px; background:#1b3322; color:white; border:none; border-radius:10px; font-size:15px; font-weight:bold; cursor:pointer; margin-top:20px; transition: 0.2s;">
                ไปที่หน้าตารางสถานะคิว ➔
            </button>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>