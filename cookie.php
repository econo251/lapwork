<?php
//ตรวจสอบว่ามีการ submit ฟอร์มหรือไม่ 
    if(!Isset($_post['submit'])){
        $username = $_post['username']; 
        setcookie("user",$username,time() + 3600); // 1 ชั่วโมง
    }
    //ตรวจสอบว่ามี cookie หรือไม่
    if (isset($_COOKIE['user'])){
        $welcome_message ="ยินดีต้อนรับกลับ คุณ" .$_cookie['user'];
    } else{
        $welcome_message ="สวัสดี ผู้เยี่ยมชมใหม่";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การใช้ cookie</title>
</head>
<body>
    <h1><?php echo $welcome_message;?></h1>
    <form method="post" action="">
        ชื่อผู้ใช้:<input type="text"name="username"required>
        <input type="submit" name="submit" value="ส่งค่า">
</form>
</body>
</html>
