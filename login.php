<?php
// ไฟล์: login.php
session_start(); // เริ่มต้นใช้งาน session

if (isset($_POST["submit"])) {
    $_SESSION["username"] = $_POST["username"];
    header("Location: home.php");
    exit;
}
?>

<h1>ทดสอบการใช้ Session</h1>
<form method="post">
    ชื่อผู้ใช้: <input type="text" name="username" required>
    <input type="submit" name="submit" value="login">
</form>
