<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP POST</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Name: <input type="text" name="fname" required>
        Last Name: <input type="text" name="lname" required>
        <input type="submit" value="ยืนยัน">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name =  $_POST['fname'];
        $lastname =$_POST['lname'];
        if (empty($name)) {
            echo "Name is empty";
        } else {
            echo "Last Name: " . $lastname;
        }
    }
    ?>
</body>
</html>
