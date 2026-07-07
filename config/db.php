
<?php
$host = 'localhost';
$db   = 'library_bookings'; // 🚨 ตรงนี้สำคัญมาก! เช็กใน phpMyAdmin ดูว่าชื่อฐานข้อมูลของนายสะกดแบบนี้ไหม (เช่น library หรือ it_beach)
$user = 'root';     // ค่าเริ่มต้นของ XAMPP คือ root
$pass = '';         // ค่าเริ่มต้นของ XAMPP คือว่างเปล่า (ไม่มีรหัสผ่าน)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // ส่งข้อความกลับไปบอกฝั่ง JavaScript ให้รู้ว่าติดปัญหาที่แนวไหน
     header('Content-Type: application/json');
     echo json_encode(['error' => 'เชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage()]);
     exit;
}