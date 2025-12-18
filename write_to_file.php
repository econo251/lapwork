<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "adsanai nakphu\n";
fwrite($myfile, $txt);
$txt = "อรรษนัย นาคภู่\n";
fwrite($myfile, $txt);
fclose($myfile);
echo"บันทึกข้อมูลงไฟล์เรียบร้อย";
?>
