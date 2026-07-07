<?php
header('Content-Type: application/json');
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$date = $_POST['booking_date'] ?? '';
$resource = $_POST['resource_type'] ?? '';

if (empty($date) || empty($resource)) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT time_slot FROM library_bookings WHERE booking_date = ? AND resource_type = ? AND status != 'Cancelled'");
    $stmt->execute([$date, $resource]);
    $booked_slots = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(['booked_slots' => $booked_slots]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error']);
}
?>