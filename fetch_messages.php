<?php
require_once 'connect.php';

// รับ room_id จากคำขอ GET
$id = $_GET['id'];

// ดึงข้อความทั้งหมดสำหรับห้องนี้
$sql = "SELECT * FROM chat_messages WHERE room_id = '$id' ORDER BY created_at ASC";
$result = $conn->query($sql);

$messages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// ส่งข้อความในรูปแบบ JSON
header('Content-Type: application/json');
echo json_encode($messages);

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
