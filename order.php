<?php
// Check if product details are passed via GET
if (!isset($_GET['title']) || !isset($_GET['price']) || !isset($_GET['image'])) {
    echo "<h3>Product details not found!</h3>";
    exit;
}

// Sanitize input to prevent XSS attacks
$product_title = htmlspecialchars($_GET['title']);
$product_price = htmlspecialchars($_GET['price']);
$product_image = htmlspecialchars($_GET['image']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Product - <?php echo $product_title; ?></title>
    <link rel="stylesheet" href="style.css"> <!-- Include CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #aaa;
        }
        .product-details {
            text-align: center;
        }
        .product-details img {
            width: 100%;
            max-width: 200px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #ff4081;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #d81b60;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Order Details</h2>
    <div class="product-details">
        <img src="products/<?php echo $product_image; ?>" alt="<?php echo $product_title; ?>">
        <h3><?php echo $product_title; ?></h3>
        <p><strong>Price:</strong> ₹<?php echo $product_price; ?></p>
    </div>

    <!-- Order Form -->
    <form action="place_order.php" method="POST">
        <input type="hidden" name="product_title" value="<?php echo $product_title; ?>">
        <input type="hidden" name="price" value="<?php echo $product_price; ?>">
        <input type="hidden" name="image" value="<?php echo $product_image; ?>">

        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Address:</label>
            <textarea name="address" required></textarea>
        </div>

        <div class="form-group">
            <label>Phone Number:</label>
            <input type="text" name="phone" required>
        </div>

        <div class="form-group">
            <label>Payment Method:</label>
            <select name="payment_method">
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>
        </div>

        <button type="submit">Place Order</button>
    </form>
</div>

</body>
</html>
