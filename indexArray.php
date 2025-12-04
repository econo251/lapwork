<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Php Array (เรียนวันที่ 4/12/2568)</title>
</head>
<body>
    <?php
    $cars = array("Volvo", "BMW", "Toyota");
    echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";
    ?>
    <h1> ทดสอบ Array แบบ Associative Arrays</h1>
    <?php
    $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43"); echo "Peter is " . $age['Peter'] . " years old.";
    echo "Peter is " . $age['Peter'] . " years old," . "<br>";
    echo "Ben is " . $age['Ben'] . " years old," . "<br>";
    echo "Joe is " . $age['Joe'] . " years old," . "<br>";
    echo "Mon is " . $age['Mon'] . " years old," . "<br>";
?>
<h1> การใช้ For กับ Index Arrays </h1>
<?php
$fruits = array("แอบเปิ้ล","มะละกอ", "กล้วย","ส้ม","องุ่น","มังคุด","ทุเรียน");
$arrlen = count($fruits);

for($x = 0; $x < $arrlen; $x++){
    echo $fruits[$x]; 
    echo "<br>\n";
}
?>
<h1> การใช้ Foreach กับ Index Arrays </h1>
<?php
$fruits = array("แอบเปิ้ล","มะละกอ", "กล้วย","ส้ม","องุ่น","มังคุด","ทุเรียน");
foreach($fruits as $value){
    echo $value;
    echo "<br>\n";
}
?>
<h1> การใช้ Foreach กับ Associative Arrays </h1>
<?php
$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43", "Bas"=>"19");

foreach($age as $x => $x_value){
    echo $x . " มีอายุ " . $x_value . " ปี";
    echo "<br>\n";
}
?>
</body>
</html>
