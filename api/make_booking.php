<?php
// api/make_booking.php
header('Content-Type: application/json');

// --- 🛠️ ส่วนเชื่อมต่อฐานข้อมูลตรง ๆ (กันเหนียว ป้องกัน $conn เป็น null) ---
$host = "localhost";
$db_name = "library_bookings"; // ชื่อฐานข้อมูลของนาย
$username = "root";            // ปกติ XAMPP เป็น root
$password = "";                // ปกติ XAMPP จะว่างไว้

try {
    // สร้างการเชื่อมต่อ PDO และยัดใส่ตัวแปร $conn ให้เห็นกันจะ ๆ ในไฟล์นี้เลย
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo json_encode(['success' => false, 'message' => '💥 เชื่อมต่อฐานข้อมูลไม่ผ่านในฝั่ง PHP: ' . $exception->getMessage()]);
    exit;
}
// -------------------------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $student_id = trim($_POST['student_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $resource_type = trim($_POST['resource_type'] ?? '');
    $booking_date = trim($_POST['booking_date'] ?? '');
    $time_slot = trim($_POST['time_slot'] ?? '');

    if (empty($student_id) || empty($name) || empty($booking_date) || empty($time_slot)) {
        echo json_encode(['success' => false, 'message' => '⚠️ กรุณากรอกข้อมูลสำคัญให้ครบถ้วน']);
        exit;
    }

    try {
        // =======================================================
        // 🔒 [สเต็ปที่ 1] ดักจับการจองซ้ำวันละ 1 สิทธิ์
        // =======================================================
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM library_bookings WHERE student_id = ? AND booking_date = ? AND status != 'cancelled'");
        $check_stmt->execute([$student_id, $booking_date]);
        $already_booked = $check_stmt->fetchColumn();

        if ($already_booked > 0) {
            echo json_encode([
                'success' => false, 
                'message' => '❌ ไม่สามารถจองเพิ่มได้ เนื่องจากรหัสนักศึกษานี้ได้จองคิวในวันที่เลือกไปแล้ว (จำกัดวันละ 1 สิทธิ์)'
            ]);
            exit;
        }

        // =======================================================
        // 🎫 [สเต็ปที่ 2] บันทึกข้อมูลลงตาราง library_bookings
        // =======================================================
        $queue_number = "LIB-" . sprintf("%04d", rand(1, 9999)); 
        $booking_code = "ITB-" . rand(1000, 9999); 

        $insert_stmt = $conn->prepare("INSERT INTO library_bookings (queue_number, booking_code, student_id, name, phone, resource_type, booking_date, time_slot, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $insert_stmt->execute([$queue_number, $booking_code, $student_id, $name, $phone, $resource_type, $booking_date, $time_slot]);

        // =======================================================
        // 💬 [สเต็ปที่ 3] ยิงข้อความแจ้งเตือนเข้า Discord Webhook
        // =======================================================
        $discord_webhook_url = "https://discord.com/api/webhooks/1518178618667302994/dxh2S8JxdJhC_yOv3CbRI2CUHaIymUMV0T3dcJ6bE1tid7efrwjsRXwSdZRsAJFZvST5"; 

        $msg_content = "🎉 **มีรายการจองคิวใหม่เข้ามาแล้วนาย!** \n"
                     . "━━━━━━━━━━━━━━━━━━━━\n"
                     . "🎫 **รหัสคิว:** `" . $queue_number . "`\n"
                     . "🔒 **รหัสลับยกเลิก:** `" . $booking_code . "`\n"
                     . "👤 **ผู้จอง:** " . $name . " (" . $student_id . ")\n"
                     . "📦 **บริการที่จอง:** " . $resource_type . "\n"
                     . "📅 **วันที่ใช้งาน:** " . $booking_date . "\n"
                     . "⏰ **ช่วงเวลา:** " . $time_slot . "\n"
                     . "━━━━━━━━━━━━━━━━━━━━\n"
                     . "👉 *สามารถเช็กสถานะคิวทั้งหมดได้ที่หน้าเว็บสเตตัสเลยครับ*";

        $json_data = json_encode([
            "content" => $msg_content,
            "username" => "ระบบจองคิวอัจฉริยะ 🌿", 
            "avatar_url" => "https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=200" 
        ], JSON_UNESCAPED_UNICODE);

        $ch = curl_init($discord_webhook_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $discord_response = curl_exec($ch);
        curl_close($ch);

        // ส่งผลลัพธ์กลับหน้าบ้านรันอนิเมชันความยินดี
        echo json_encode([
            'success' => true,
            'queue_number' => $queue_number,
            'booking_code' => $booking_code,
            'data' => [
                'student_id' => $student_id,
                'name' => $name,
                'resource' => $resource_type,
                'date' => $booking_date,
                'time' => $time_slot
            ]
        ]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในระบบฐานข้อมูล: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => '⚠️ Method not allowed']);
}