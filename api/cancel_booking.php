<?php
header('Content-Type: application/json');
require_once '../config/db.php'; // ดูให้ดีว่าโฟลเดอร์เชื่อม db อยู่ตรงนี้นะนาย

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// รับค่ารหัสนักศึกษา และ รหัสคิวลับ ที่เด็กกรอกมา
$student_id = htmlspecialchars(strip_tags($_POST['student_id'] ?? ''));
$booking_code = htmlspecialchars(strip_tags($_POST['booking_code'] ?? ''));

if (empty($student_id) || empty($booking_code)) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
    exit;
}

try {
    // 🔍 เช็กก่อนว่ามีคิวนี้อยู่จริงไหม และรหัสนักศึกษาตรงกันไหม
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM library_bookings WHERE student_id = ? AND booking_code = ?");
    $stmt->execute([$student_id, $booking_code]);
    
    if ($stmt->fetchColumn() == 0) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง หรือรหัสคิวไม่ถูกต้องครับนาย!']);
        exit;
    }

    // 🔴 ทำการอัปเดตสถานะให้เป็น 'canceled' (ไม่ใช้วิธีลบแถวทิ้ง เพื่อเก็บข้อมูลไว้ดูสถิติ)
    $sql = "UPDATE library_bookings SET status = 'canceled' WHERE student_id = ? AND booking_code = ?";
    $updateStmt = $pdo->prepare($sql);
    $updateStmt->execute([$student_id, $booking_code]);

    echo json_encode(['success' => true, 'message' => 'ยกเลิกการจองคิวของนายเรียบร้อยแล้วครับ!']);
    exit;

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
    exit;
}
?>