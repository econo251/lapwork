<!DOCTYPE html>
<html lang="en">
<?php
$myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
echo fgets($myfile)."<br>";
while(!feof($myfile)) {
  echo fgetc($myfile) . "<br>"; //อ่านทีละตัวอักษร
}
fclose($myfile);
?>

<body>
    
</body>
</html>
