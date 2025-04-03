<?php
$conn = new mysqli("localhost", "root", "", "ck");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #007bff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            background: #0056b3;
            border-radius: 5px;
        }
        .navbar a:hover {
            background: #003d80;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            text-align: center;
        }
        .menu-item {
            background: white;
            padding: 15px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .menu-item h4 {
            margin: 0;
            color: #333;
        }
        .menu-item p {
            color: #555;
        }
        .price {
            font-size: 18px;
            font-weight: bold;
            color: #28a745;
        }
        .category {
            background: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2 style="color:white; margin:0;">Restaurant</h2>
    <a href="admin_login.php">Admin Login</a>
</div>

<!-- Menu Items -->
<div class="container">
    <h2>Our Menu</h2>
    
    <?php
    $query = "SELECT * FROM menu";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='menu-item'>
                <h4>{$row['dish_name']}</h4>
                <p>{$row['description']}</p>
                <p class='price'>₹{$row['price']}</p>
                <span class='category'>{$row['category']}</span>
            </div>";
        }
    } else {
        echo "<p>No dishes available.</p>";
    }
    ?>
</div>

</body>
</html>
