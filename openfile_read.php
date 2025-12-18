<!DOCTYPE html>
<html lang="en">
<?php
$myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("webdictionary.txt"));
fclose($myfile);
?>
<body>
    
</body>
</html>
