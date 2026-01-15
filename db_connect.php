<?php
$servername = "localhost";
$username   = "root";        // ✅ XAMPP ใช้ root
$password   = "";            // ✅ ปล่อยว่าง
$database   = "2568webapp";  // ❗ ชื่อ DB ของคุณจริง ๆ

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
