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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM menu WHERE id = $id";

    if ($conn->query($query)) {
        echo "<script>alert('Dish removed successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
