<?php
session_start(); // เริ่มต้นใช้งาน session

echo "ชื่อผู้ใช้: " . $_SESSION['username'] . "<br>";
echo "สิทธิ์: " . $_SESSION['role'];
?>
