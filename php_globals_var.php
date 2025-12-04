<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>การใช้ $GLOBALS</h1>
    <?php
    $x = 75;
    $y = 25;

    function addition() {
        $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
    }
    addition();
    echo $z;
    ?>

    <?php
    echo $_SERVER ['PHP_SELF'];
    echo "<br>";
     echo $_SERVER ['SERVER_NAME'];
     echo "<br>";
     echo $_SERVER ['HTTP_HOST'];
     echo "<br>";
     echo $_SERVER ['HTTP_USER_AGENT'];
     echo "<br>";
     echo $_SERVER ['SCRIPT_NAME'];
     ?>
</body>
</html>
