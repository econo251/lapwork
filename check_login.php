<?php
session_start(); // เริ่มต้นใช้งาน session

if (!isset($_SESSION["username"])) {
    echo "กรุณาเข้าสู่ระบบ";
} else {
    echo "ยินดีต้อนรับ " . $_SESSION["username"];
}
?>
