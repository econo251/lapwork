<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome POST</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9f0f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            width: 360px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        .info {
            font-size: 16px;
            color: #444444;
            margin: 10px 0;
            padding: 10px;
            background: #f7f9fa;
            border-radius: 8px;
            border: 1px solid #dcdcdc;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Welcome!</h2>

    <div class="info">
        <strong>Name:</strong> 
        <?php echo htmlspecialchars($_POST["name"]); ?>
    </div>

    <div class="info">
        <strong>Email:</strong> 
        <?php echo htmlspecialchars($_POST["email"]); ?>
    </div>
</div>

</body>
</html>
