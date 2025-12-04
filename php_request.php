<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Request</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Name: <input type="text" name="fname" required>
        Last Name: <input type="text" name="lname" required>
        <input type="submit" value="ยืนยัน">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['fname']);
        $lastname = htmlspecialchars($_POST['lname']);
        if (empty($name)) {
            echo "Name is empty";
        } else {
            echo "Name: " . $name . "<br>";
            echo "Last Name: " . $lastname;
        }
    }
    ?>
</body>
</html>
