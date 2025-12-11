<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP built-in Function ฟังก์ชั่นที่มีพร้อมใช้ php</title>
</head>
<body>
    <h1>PHP built-in Function ฟังก์ชั่นที่มีพร้อมใช้ php</h1>

    <h2>ทดสอบการใช้ Function date()</h2>
    <?php
        echo "วันนี้วันที่ " . date("d/m/Y") . "<br>";
        echo "เวลาปัจจุบัน " . date("h:i:sa") . "<br>";
        echo "วันนี้เป็นวัน " . date("l") . "<br>";
    ?>

    <h2>ทดสอบการใช้ Function date_diff()</h2>
    <?php
        $date1 = date_create("2005-09-03");
        $date2 = date_create("2025-12-11");
        $diff = date_diff($date1, $date2);

        echo "จำนวนวันระหว่างวันที่ 3 กันยายน 2005 ถึง 11 ธันวาคม 2025 คือ "
            . $diff->days . " วัน<br>";

        echo "หรือเท่ากับ " . $diff->y . " ปี " . $diff->m . " เดือน " . $diff->d . " วัน<br>";
    ?>

    <h2>ทดสอบการใช้ Math function</h2>
    <?php
        $num1 = 10.7; 
        $num2 = 15.3;
        $pi   = 3.14159;

        echo "ค่าปัดเศษขึ้นของ $num1 คือ " . ceil($num1) . "<br>";
        echo "ค่าปัดเศษลงของ $num2 คือ " . floor($num2) . "<br>";
        echo "ค่าของ pi ปัดเป็นทศนิยม 2 ตำแหน่ง คือ " . round($pi, 2) . "<br>";
        echo "ค่า pi คือ " . pi() . "<br>";
        echo "ค่ายกกำลัง 3 ของ 5 คือ " . pow(5, 3) . "<br>";
        echo "ค่ารากที่สองของ 49 คือ " . sqrt(49) . "<br>";
        echo "ค่าสุ่มระหว่าง 1 ถึง 100 คือ " . rand(1, 100) . "<br>";
        echo "ค่าสุ่มระหว่าง 50 ถึง 150 คือ " . rand(50, 150) . "<br>";
        echo "ค่าสุ่ม คือ " . rand() . "<br>";

        $arr = array(3, 5, 1, 8, 2);
        echo "ค่าสูงสุดใน array คือ " . max($arr) . "<br>";
        echo "ค่าต่ำสุดใน array คือ " . min($arr) . "<br>";
    ?>
</body>
</html>
