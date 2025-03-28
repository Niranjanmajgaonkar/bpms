<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #4CAF50, #8BC34A);
        }
        .container {
            background: white;
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }
        .success-icon {
            font-size: 50px;
            color: #4CAF50;
        }
        h2 {
            color: #333;
            margin-top: 10px;
        }
        p {
            color: #666;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #388E3C;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="success-icon">✅</div>
    <h2>Order Placed Successfully!</h2>
    <p>Thank you for your order. We will deliver your product soon.</p>
    <a href="index.php" class="btn">Back to Home</a>
</div>

</body>
</html>
