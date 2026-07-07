<?php
header('Content-Type: application/json');
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false]);
    exit;
}

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';

if(empty($id) || empty($status)) {
    echo json_encode(['success' => false]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE library_bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false]);
}
?>