<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "bpmsdb";

// Create connection
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields exist before using them
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $product_title = isset($_POST['product_title']) ? $_POST['product_title'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;

    // Ensure required fields are not empty
    if (!$product_title || !$name || !$address || !$phone || !$payment_method || !$price) {
        die("Error: Missing required fields.");
    }

    // Insert into orders table (handling product_id as nullable)
    $query = "INSERT INTO orders (product_id, product_title, customer_name, address, phone, payment_method, price, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $con->prepare($query);

    if ($product_id) {
        $stmt->bind_param("isssssd", $product_id, $product_title, $name, $address, $phone, $payment_method, $price);
    } else {
        $product_id = null;
        $stmt->bind_param("isssssd", $product_id, $product_title, $name, $address, $phone, $payment_method, $price);
    }

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        echo "Error placing order: " . $stmt->error;
    }

    $stmt->close(); // Close statement
}
?>
