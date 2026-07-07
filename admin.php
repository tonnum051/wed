<?php
require_once 'config/db.php';

$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));

try {
    // 💡 ปรับคำสั่ง SQL ให้ดึงข้อมูลมาเรียงอย่างถูกต้องและดึง booking_code ออกมาแสดงผลด้วย
    $stmt = $pdo->prepare("SELECT * FROM library_bookings WHERE booking_date IN (?, ?) ORDER BY booking_date ASC, time_slot ASC");
    $stmt->execute([$today, $tomorrow]);
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching bookings: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard - จัดการคิวห้องสมุด</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <header class="admin-header">
            <h1>🧑‍💼 แผงควบคุมเจ้าหน้าที่ห้องสมุด (Librarian Dashboard)</h1>
            <p>แสดงข้อมูลการจองคิวประจำวันที่: <?php echo date('d/m/Y'); ?></p>
        </header>

        <section class="table-section">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>รหัสคิว</th>
                        <th style="color: #e53e3e; background: #fff5f5;">รหัสคิวลับ (สำหรับยกเลิก)</th> <th>วันที่จอง</th>
                        <th>รอบเวลา</th>
                        <th>ประเภททรัพยากร</th>
                        <th>รหัสนักศึกษา</th>
                        <th>ชื่อผู้จอง</th>
                        <th>เบอร์โทร</th>
                        <th>สถานะ</th>
                        <th>การจัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr><td colspan="10" style="text-align:center;">🎉 ยังไม่มีข้อมูลการจองคิวในวันนี้และวันพรุ่งนี้</td></tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $row): 
                            // 💡 ดึงจากฟิลด์ queue_number ในตารางฐานข้อมูลโดยตรง ไม่ต้องเขียนสูตร str_pad ประกอบเองให้เลขอักขระเพี้ยนครับ
                            $q_id = !empty($row['queue_number']) ? $row['queue_number'] : "LIB-" . str_pad($row['id'], 4, '0', STR_PAD_LEFT);
                        ?>
                            <tr class="status-row-<?php echo strtolower($row['status']); ?>">
                                <td><strong style="color: #2b6cb0;"><?php echo $q_id; ?></strong></td>
                                
                                <td style="background: #f7fafc; font-weight: bold; color: #2d3748; text-align: center;">
                                    <?php echo htmlspecialchars($row['booking_code'] ?? 'ไม่มีรหัส'); ?>
                                </td>

                                <td><?php echo date('d/m/Y', strtotime($row['booking_date'])); ?></td>
                                <td><span class="badge-time"><?php echo $row['time_slot']; ?></span></td>
                                <td><?php echo $row['resource_type']; ?></td>
                                <td><?php echo $row['student_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td>
                                    <?php
                                        // ปรับการแปลงสถานะให้อ่านง่ายและรองรับตัวพิมพ์เล็ก-ใหญ่
                                        $current_status = strtolower($row['status']);
                                        $status_text = $row['status'];
                                        if ($current_status == 'pending') $status_text = 'รอดำเนินการ';
                                        if ($current_status == 'checked-in') $status_text = 'ยืนยันเข้าใช้';
                                        if ($current_status == 'no-show') $status_text = 'ไม่มาตามนัด';
                                        if ($current_status == 'cancelled' || $current_status == 'canceled') $status_text = 'ยกเลิกคิว';
                                    ?>
                                    <span class="status-badge <?php echo $current_status; ?>"><?php echo $status_text; ?></span>
                                </td>
                                <td>
                                    <select class="change-status" onchange="updateStatus(<?php echo $row['id']; ?>, this.value)">
                                        <option value="Pending" <?php if(strcasecmp($row['status'], 'Pending') == 0) echo 'selected'; ?>>รอดำเนินการ</option>
                                        <option value="Checked-in" <?php if(strcasecmp($row['status'], 'Checked-in') == 0) echo 'selected'; ?>>ยืนยันเข้าใช้</option>
                                        <option value="No-show" <?php if(strcasecmp($row['status'], 'No-show') == 0) echo 'selected'; ?>>ไม่มาตามนัด</option>
                                        <option value="Cancelled" <?php if(strcasecmp($row['status'], 'Cancelled') == 0 || strcasecmp($row['status'], 'Canceled') == 0) echo 'selected'; ?>>ยกเลิกคิว</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>

    <script>
    async function updateStatus(id, newStatus) {
        if(!confirm('คุณต้องการเปลี่ยนสถานะของคิวนี้ใช่หรือไม่?')) {
            location.reload();
            return;
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', newStatus);

        try {
            const response = await fetch('api/update_status.php', {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();
            if(result.success) {
                alert('อัปเดตสถานะคิวสำเร็จ!');
                location.reload(); 
            } else {
                alert('ไม่สามารถอัปเดตสถานะได้: ' + (result.message || 'เกิดข้อผิดพลาดไม่ทราบสาเหตุ'));
                location.reload();
            }
        } catch (error) {
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์ (กรุณาตรวจสอบไฟล์ api/update_status.php)');
            location.reload();
        }
    }
    </script>
</body>
</html>