<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connect.php';

// รับชื่อและ id จาก URL
$name = $_GET['name'];  // รับชื่อจาก URL
$id = $_GET['id'];      // รับ id จาก URL

// ตรวจสอบการส่งข้อความใหม่
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];  // รับข้อความจากฟอร์ม
    // บันทึกข้อความใหม่ลงในฐานข้อมูล
    $sql = "INSERT INTO chat_messages (room_id, name, message, created_at) 
            VALUES ('$id', '$name', '$message', NOW())";  // บันทึกข้อความ
    if ($conn->query($sql) === TRUE) {
        // ถ้าสำเร็จ, รีเฟรชหน้าเว็บเพื่อแสดงข้อความใหม่
        header("Location: welcome.php?name=" . urlencode($name) . "&id=" . urlencode($id));
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

$sql_room = "SELECT * FROM RoomDetails WHERE id = '$id'";
$result_room = $conn->query($sql_room);
$room = null;
if ($result_room->num_rows > 0) {
    $room = $result_room->fetch_assoc();
}

// ดึงข้อมูลทั้งหมดจากตาราง chat_messages สำหรับห้องนั้น
$sql = "SELECT * FROM chat_messages WHERE room_id = '$id' ORDER BY created_at ASC";  // ดึงข้อความจากห้องที่กำหนด
$result = $conn->query($sql);

function formatThaiDate($dateTime) {
    $thaiMonths = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
        7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    ];

    $date = new DateTime($dateTime);
    $day = $date->format('j');
    $month = $thaiMonths[(int)$date->format('n')];
    $year = $date->format('Y') + 543; // เพิ่มปีพุทธศักราช

    return "$day $month $year";
}

function formatThaiTime($datetime) {
    $time = new DateTime($datetime);
    return $time->format('H:i:s'); // แสดงเฉพาะเวลา
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ห้องแชท</title>
    <link rel="stylesheet" href="welcome.css">
</head>
<body>
    <!-- เริ่มต้น Header -->
    <header class="header">
        <div class="header-logo-container">
            <img src="https://bangkok.traffy.in.th/assets/ic_traffy1-3adc9d55.png" alt="Logo 1" class="header-logo">
            <img src="https://bangkok.traffy.in.th/assets/ic_traffy2-b99cb1d3.png" alt="Logo 2" class="header-logo">
            <img src="https://bangkok.traffy.in.th/assets/ic_bangkok-5e09ba9f.png" alt="Logo 3" class="header-logo">
        </div>
    </header>
    <!-- จบ Header -->

    <div class="chat-room">
    <?php if ($room): ?>
        <p class="room-info">คุณกำลังอยู่ในห้องแชท: <?php echo htmlspecialchars($room['title']); ?> | 
        สถานะ: <?php echo htmlspecialchars($room['status']); ?> | 
        สร้างเมื่อ: <?php echo formatThaiDate($room['created_at']); ?></p>
    <?php else: ?>
        <p>ไม่พบข้อมูลห้องนี้</p>
    <?php endif; ?>

    <!-- แสดงข้อความทั้งหมดจากห้องแชท -->
     
    <div class="messages-container" id="messages-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <!-- ตรวจสอบว่าผู้ส่งเป็นผู้ใช้หรือไม่ -->
                <div class="message <?php echo ($row['name'] == $name) ? 'left' : 'right'; ?>">
                 <strong><?php echo htmlspecialchars($row['name']); ?> 
                    <em><?php echo formatThaiDate($row['created_at']); ?> เวลา <?php echo formatThaiTime($row['created_at']); ?></em> :</strong>
                    <p><?php echo htmlspecialchars($row['message']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>ยังไม่มีข้อความในห้องนี้</p>
        <?php endif; ?>
    </div>

    <!-- ฟอร์มส่งข้อความ -->
    <form method="POST" action="">
        <div class="message-form">
            <label for="message" class="message-name">ชื่อของคุณ: <?php echo htmlspecialchars($name); ?></label>
            <textarea name="message" id="message" rows="3" placeholder="พิมพ์ข้อความ..." required></textarea>
        </div>
        <button type="submit">ส่งข้อความ</button>
        <button type="button" onclick="window.location.href='index.php';">กลับไปยังหน้าแรก</button>
    </form>
</div>
<script>
    // ดักจับการกดปุ่ม Enter
document.getElementById('message').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {  // ตรวจสอบว่าเป็นการกด Enter และไม่กด Shift ควบคู่
        e.preventDefault(); // ป้องกันไม่ให้สร้างบรรทัดใหม่
        document.querySelector('form').submit(); // ส่งฟอร์มเมื่อกด Enter
    }
});

function formatThaiDate(dateTime) {
    const thaiMonths = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];

    const date = new Date(dateTime);
    const day = date.getDate(); // วันที่
    const month = thaiMonths[date.getMonth()]; // เดือน (จาก 0-11)
    const year = date.getFullYear() + 543; // เพิ่มปีพุทธศักราช
    return `${day} ${month} ${year}`;
}

function formatThaiTime(dateTime) {
    const date = new Date(dateTime);
    return date.toLocaleTimeString('th-TH'); // แสดงเวลาในรูปแบบ HH:MM:SS
}

function loadMessages() {
    const roomId = "<?php echo $id; ?>";
    const name = "<?php echo htmlspecialchars($name); ?>";

    fetch(`fetch_messages.php?id=${roomId}`)
        .then(response => response.json())
        .then(data => {
            const messagesContainer = document.querySelector('.messages-container');
            messagesContainer.innerHTML = ''; // ล้างข้อความเก่าก่อนโหลดใหม่

            data.forEach(row => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${row.name === name ? 'left' : 'right'}`;
                messageDiv.innerHTML = `
                    <strong>${row.name} 
                        <em>${formatThaiDate(row.created_at)} เวลา ${formatThaiTime(row.created_at)}</em>:</strong>
                    <p>${row.message}</p>
                `;
                messagesContainer.appendChild(messageDiv);
            });

            // เลื่อนหน้าจอไปด้านล่างสุด
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .catch(error => console.error('Error fetching messages:', error));
}


// เรียกฟังก์ชัน loadMessages ทุกๆ 2 วินาที
setInterval(loadMessages, 2000);

// โหลดข้อความทันทีเมื่อหน้าเว็บโหลด
loadMessages();


</script>
    </div>

</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
