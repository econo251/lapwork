<?php
// home.php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

echo "ยินดีต้อนรับ " . $_SESSION["username"];
?>
<br>
<a href="logout.php">ออกจากระบบ</a>
