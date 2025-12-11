<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การใช้ User-define Function ฟังก์ชั่นที่สร้างขึ้นเอง</title>
</head>
<body>
    <h1>การใช้ User-define Function ฟังก์ชั่นที่สร้างขึ้นเอง</h1>

<?php
echo "ผลบวกของ 10 กับ 20 คือ = " . sum(10, 20) . "<br>";
echo "ผลบวกของ 15 กับ 25 คือ = " . sum(15, 25) . "<br>";

$a = 30;
$b = 45;

echo "ผลบวกของ $a กับ $b คือ = " . sum($a, $b) . "<br><br>";

$num = 50;
echo "ค่าของ num ก่อนเรียกฟังก์ชัน add_five() คือ $num<br>";

$new_num = add_five($num);
echo "ค่าที่ได้จาก add_five() คือ $new_num<br>";
echo "ค่าของ num หลังการเรียกฟังก์ชัน add_five() คือ $num (ค่าไม่เปลี่ยน เพราะส่งแบบค่า)<br>";
?>

<h2>ตัวอย่าง function ที่มีพารามิเตอร์หลายตัว</h2>

<?php
function sumListofNumber(...$x){
    $n = 0;
    foreach ($x as $value){
        $n += $value;
    }
    return $n;
}

echo "ผลบวกของตัวเลข 10, 20, 30 คือ = " . sumListofNumber(10,20,30) . "<br>";
echo "ผลบวกของตัวเลข 1-10 คือ = " . sumListofNumber(1,2,3,4,5,6,7,8,9,10) . "<br>";

function myFamilyNames($lastName, ...$names){
    foreach($names as $firstName){
        echo "สวัสดี คุณ " . $firstName . " " . $lastName . "<br>";
    }
}

myFamilyNames("สวยใส","สมชาย","สมศักดิ์","สมหมาย","สมพร");
?>

<h2>ตัวอย่าง function ที่มีพารามิเตอร์ค่าเริ่มต้น</h2>

<?php
function thai_date($strDate = "now"){
    $strYear = date("Y",strtotime($strDate)) + 543;
    $strMonth = date("n",strtotime($strDate));
    $strDay = date("j",strtotime($strDate));

    $strMonthNames = ["","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
                      "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];

    
    $strMonthThai = $strMonthNames[$strMonth];

    return "$strDay $strMonthThai พ.ศ. $strYear";
}

echo thai_date("2025-12-11") . "<br>";
echo thai_date(); 
?>
</body>
</html>

<?php
function sum($num1, $num2) {
    return $num1 + $num2;
}

function add_five($num) {
    return $num + 5;
}
?>
