<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = htmlspecialchars($_POST['fullname']);
    $email    = htmlspecialchars($_POST['email']);
    $course   = htmlspecialchars($_POST['course']);
    $type     = $_POST['type'] ?? "ไม่ระบุ";
    $food     = isset($_POST['food']) ? implode(",", $_POST['food']) : "ไม่ระบุ";

    $price = ($type == "Onsite") ? 1500 : 800;

    $data = "$fullname|$email|$course|$food|$type|$price\n";
    file_put_contents("register.txt", $data, FILE_APPEND);

    // ป้องกัน refresh ซ้ำ
    header("Location: ".$_SERVER['PHP_SELF']."?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ระบบลงทะเบียนอบรม</title>

<style>
body{
    font-family:'Segoe UI',Tahoma;
    background:linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
    padding:40px 15px;
}
.container{
    background:#fff;
    max-width:900px;
    margin:0 auto 35px;
    padding:30px;
    border-radius:15px;
    box-shadow:0 15px 40px rgba(0,0,0,.15);
}
h2,h3{
    border-left:6px solid #667eea;
    padding-left:12px;
    color:#34495e;
}
input[type=text],input[type=email],select{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ddd;
    margin-top:5px;
}
button{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:#fff;
    padding:14px 30px;
    border:none;
    border-radius:30px;
    font-size:16px;
    cursor:pointer;
}
button:hover{
    box-shadow:0 10px 25px rgba(102,126,234,.4);
    transform:translateY(-2px);
}
.success{
    background:linear-gradient(135deg,#43e97b,#38f9d7);
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    color:#0b3d2e;
}
table{
    width:100%;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
}
th{
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:#fff;
    padding:12px;
}
td{
    padding:10px;
    border-bottom:1px solid #eee;
}
tr:nth-child(even){background:#f8f9ff;}
</style>
</head>

<body>

<div class="container">
<h2>ฟอร์มลงทะเบียนอบรม</h2>

<?php if(isset($_GET['success'])){ ?>
    <div class="success">ลงทะเบียนสำเร็จ 🎉</div>
<?php } ?>

<form method="post">
    <strong>ชื่อ-นามสกุล</strong>
    <input type="text" name="fullname" required>

    <strong>Email</strong>
    <input type="email" name="email" required>

    <strong>หัวข้ออบรม</strong>
    <select name="course">
        <option>AI สำหรับงานสำนักงาน</option>
        <option>Excel สำหรับการทำงาน</option>
        <option>การเขียนเว็บด้วย PHP</option>
    </select>

    <strong>อาหารที่ต้องการ</strong><br>
    <input type="checkbox" name="food[]" value="ปกติ"> ปกติ
    <input type="checkbox" name="food[]" value="มังสวิรัติ"> มังสวิรัติ
    <input type="checkbox" name="food[]" value="ฮาลาล"> ฮาลาล
    <br><br>

    <strong>รูปแบบการเข้าร่วม</strong><br>
    <input type="radio" name="type" value="Onsite" required> Onsite
    <input type="radio" name="type" value="Online"> Online
    <br><br>

    <button type="submit">ลงทะเบียน</button>
</form>
</div>

<div class="container">
<h3>รายชื่อผู้ลงทะเบียนทั้งหมด</h3>

<?php
if (file_exists("register.txt")) {
    echo "<table>
            <tr>
                <th>ชื่อ</th>
                <th>Email</th>
                <th>หัวข้อ</th>
                <th>อาหาร</th>
                <th>รูปแบบ</th>
                <th>ราคา (บาท)</th>
            </tr>";

    $lines = file("register.txt");
    foreach ($lines as $line) {
        list($n,$e,$c,$f,$t,$p) = explode("|", trim($line));
        echo "<tr>
                <td>$n</td>
                <td>$e</td>
                <td>$c</td>
                <td>$f</td>
                <td>$t</td>
                <td>".number_format($p,2)."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "ยังไม่มีข้อมูล";
}
?>
</div>

</body>
</html>
