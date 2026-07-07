<?php
header('Content-Type: application/json');
require_once '../config/db.php';

try {
    // ดึงข้อมูลการจองเฉพาะของ "วันนี้เป็นต้นไป" และเรียงจากวันที่และรอบเวลาล่าสุด
    $current_date = date('Y-m-d');
    $sql = "SELECT queue_number, student_id, name, resource_type, booking_date, time_slot, status 
            FROM library_bookings 
            WHERE booking_date >= ? 
            ORDER BY booking_date ASC, time_slot ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$current_date]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $bookings]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
