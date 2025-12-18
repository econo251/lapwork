<?php
$filename = "newfile.txt";
$text = "อรรษนัย " . date("Y-m-d H:i:s") . PHP_EOL;


file_put_contents($filename, $text, FILE_APPEND);

echo "บันทึกข้อมูลเรียบร้อย";
?>
