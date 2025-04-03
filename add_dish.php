<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ck");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dish_name = $_POST['dish_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $query = "INSERT INTO menu (dish_name, description, price, category) 
              VALUES ('$dish_name', '$description', '$price', '$category')";

    if ($conn->query($query)) {
        echo "<script>alert('Dish added successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
