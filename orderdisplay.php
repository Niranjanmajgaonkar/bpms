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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .orders-section {
            padding: 40px 20px;
            background: #f9f9ff;
            max-width: 100vw;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            color: #222;
            font-size: 32px;
            font-weight: 700;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: #ff4081;
            margin: 15px auto;
        }
        
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 70px;
        }
        
        .order-row {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .order-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .order-header {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .order-id {
            font-weight: bold;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.2);
            padding: 3px 10px;
            border-radius: 20px;
        }
        
        .order-status {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 3px 10px;
            border-radius: 3px;
        }
        
        .status-pending {
            background: #ffc107;
            color: #333;
        }
        
        .status-completed {
            background: #28a745;
            color: white;
        }
        
        .status-processing {
            background: #17a2b8;
            color: white;
        }
        
        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
        }
        
        .detail-group {
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .detail-label i {
            margin-right: 8px;
            color: #ff4081;
            width: 20px;
            text-align: center;
        }
        
        .detail-value {
            color: #333;
            font-size: 15px;
            padding-left: 28px;
        }
        
        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            border-top: 1px solid #eee;
            background: #f8f9fa;
        }
        
        .order-price {
            font-size: 18px;
            font-weight: bold;
            color: #ff4081;
        }
        
        .order-date {
            color: #777;
            font-size: 14px;
        }
        
        .no-orders {
            text-align: center;
            padding: 40px;
            color: #777;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .no-orders i {
            font-size: 50px;
            margin-bottom: 20px;
            color: #ddd;
        }
        
        @media (max-width: 768px) {
            .order-details {
                grid-template-columns: 1fr;
            }
            
            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .order-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body id="home">

<?php include_once('includes/header.php'); ?>

<!-- Orders Section -->
<section class="orders-section">
    <h2 class="section-title">Order Management</h2>

    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "bpmsdb");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch orders
    $sql = "SELECT * FROM orders ORDER BY id DESC";
    $result = $conn->query($sql);
    ?>

    <div class="orders-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Determine status class
                $statusClass = 'status-pending';
                if ($row['status'] == 'Completed') {
                    $statusClass = 'status-completed';
                } elseif ($row['status'] == 'Processing') {
                    $statusClass = 'status-processing';
                }
                
                echo '<div class="order-row">';
                echo '<div class="order-header">';
                echo '<span class="order-id">Order #' . htmlspecialchars($row['id']) . '</span>';
                echo '<span class="order-status ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span>';
                echo '</div>';
                
                echo '<div class="order-details">';
                echo '<div class="detail-group">';
                echo '<div class="detail-label"><i class="fas fa-tag"></i> Service</div>';
                echo '<div class="detail-value">' . htmlspecialchars($row['product_title']) . '</div>';
                echo '</div>';
                
                echo '<div class="detail-group">';
                echo '<div class="detail-label"><i class="fas fa-user"></i> Customer</div>';
                echo '<div class="detail-value">' . htmlspecialchars($row['customer_name']) . '</div>';
                echo '</div>';
                
                echo '<div class="detail-group">';
                echo '<div class="detail-label"><i class="fas fa-map-marker-alt"></i> Address</div>';
                echo '<div class="detail-value">' . htmlspecialchars($row['address']) . '</div>';
                echo '</div>';
                
                echo '<div class="detail-group">';
                echo '<div class="detail-label"><i class="fas fa-phone"></i> Phone</div>';
                echo '<div class="detail-value">' . htmlspecialchars($row['phone']) . '</div>';
                echo '</div>';
                
                echo '<div class="detail-group">';
                echo '<div class="detail-label"><i class="fas fa-credit-card"></i> Payment</div>';
                echo '<div class="detail-value">' . htmlspecialchars($row['payment_method']) . '</div>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="order-footer">';
                echo '<span class="order-price">$' . htmlspecialchars($row['price']) . '</span>';
                echo '<span class="order-date">' . htmlspecialchars($row['created_at']) . '</span>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="no-orders">';
            echo '<i class="far fa-folder-open"></i>';
            echo '<h3>No orders found</h3>';
            echo '<p>When you receive new orders, they will appear here.</p>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<!-- Close DB Connection -->
<?php $conn->close(); ?>

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