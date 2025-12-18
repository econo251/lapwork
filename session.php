<?php
session_start(); // เริ่มต้นใช้งาน session

$_SESSION['username'] = "student02";
$_SESSION['role'] = "admin";

echo "สร้าง session เรียบร้อย";
?>
