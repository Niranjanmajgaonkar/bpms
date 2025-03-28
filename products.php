<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beauty Parlour Management System | Service Page</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <style>
        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: center;
            margin: 40px 20px;
        }
        .product-card {
            width: 230px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            padding: 15px;
            background: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .product-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            color: #333;
        }
        .product-price {
            color: #d9534f;
            font-size: 16px;
            font-weight: bold;
        }
        .product-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #ff4081;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .product-btn:hover {
            background: #d81b60;
        }
    </style>
</head>
<body id="home">

<?php include_once('includes/header.php'); ?>

<!-- Products Section -->
<section>
    <h2 style="text-align: center; margin-top: 30px;">Beauty Parlour Products</h2>
    <div class="product-container">
        <?php 
        $products = [
            ["b1.jpeg", "Gold Facial Kit", "499", "product-details.php?id=1"],
            ["b2.avif", "Hair Growth Serum", "349", "product-details.php?id=2"],
            ["b3.jpeg", "Matte Nail Polish Set", "599", "product-details.php?id=3"],
            ["b4.avif", "Long-lasting Lipstick", "299", "product-details.php?id=4"],
            ["b5.jpeg", "Charcoal Face Mask", "199", "product-details.php?id=5"],
            ["b6.jpeg", "Aloe Vera Gel", "249", "product-details.php?id=6"],
            ["b7.jpeg", "Hair Spa Cream", "399", "product-details.php?id=7"],
            ["b8.jpeg", "Herbal Shampoo", "299", "product-details.php?id=8"],
            ["b9.jpeg", "Face Scrub", "199", "product-details.php?id=9"],
            ["b10.jpeg", "Whitening Face Cream", "349", "product-details.php?id=10"],
            ["b12.jpeg", "Organic Hair Oil", "499", "product-details.php?id=11"],
            ["b14.jpeg", "Cleansing Milk", "299", "product-details.php?id=12"],
            ["b15.jpeg", "Body Lotion", "399", "product-details.php?id=13"],
            ["b17.jpeg", "Rose Water Toner", "199", "product-details.php?id=14"]
        ];

        foreach ($products as $product) {
            echo '
            <div class="product-card">
                <img src="products/'.$product[0].'" alt="'.$product[1].'">
                <div class="product-title">'.$product[1].'</div>
                <div class="product-price">₹'.$product[2].'</div>
                <a href="order.php?title='.urlencode($product[1]).'&price='.urlencode($product[2]).'&image='.urlencode($product[0]).'" class="product-btn">Buy Now</a>
            </div>';
        }
        
        ?>
    </div>
</section>

<!-- JavaScript Files -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
$(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
    });
});
</script>

</body>
</html>
