<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$cart = json_decode($_POST['cart'], true);

// Insert each product into the orders table
foreach ($cart as $productId => $quantity) {
    $stmt = $conn->prepare("INSERT INTO orders (product_id, quantity, customer_name, customer_email, customer_address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $productId, $quantity, $name, $email, $address);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "Order successfully processed!";
?>
