<?php 
// เชื่อมต่อฐานข้อมูล
require_once 'connect.php';

$room_code = $_GET['room_code'];  // รับรหัสห้องจาก URL
$id = $_GET['id'];                // รับ id ห้องจาก URL

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];  // รับชื่อจากฟอร์ม
    // Redirect ไปยังห้องแชท
    header("Location: welcome.php?name=" . urlencode($name) . "&id=" . urlencode($id));
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรุณาใส่ชื่อของคุณ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="header">
        <div class="header-logo-container">
            <img src="https://bangkok.traffy.in.th/assets/ic_traffy1-3adc9d55.png" alt="Logo 1" class="header-logo">
            <img src="https://bangkok.traffy.in.th/assets/ic_traffy2-b99cb1d3.png" alt="Logo 2" class="header-logo">
            <img src="https://bangkok.traffy.in.th/assets/ic_bangkok-5e09ba9f.png" alt="Logo 3" class="header-logo">
        </div>
</header>

    <form method="POST" action="">
    <img src="https://bangkok.traffy.in.th/assets/ic_traffy1-3adc9d55.png" alt="Traffy Logo" class="form-logo">
        <label for="name">กรุณาใส่ชื่อของคุณ</label>
        <input type="text" id="name" name="name" placeholder="กรุณากรอกชื่อ" required>
        <button type="submit">ยืนยัน</button>
    </form>
</body>
</html>
