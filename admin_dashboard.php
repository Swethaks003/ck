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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .logout-btn {
            display: block;
            text-align: right;
            margin-bottom: 10px;
        }
        .logout-btn a {
            background: #dc3545;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn a:hover {
            background: #b02a37;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        .delete-btn {
            background: #dc3545;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .delete-btn:hover {
            background: #b02a37;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="logout-btn">
        <a href="logout.php">Logout</a>
    </div>

    <!-- Add Dish Form -->
    <h3>Add a New Dish</h3>
    <form action="add_dish.php" method="POST">
        <div class="form-group">
            <label>Dish Name</label>
            <input type="text" name="dish_name" required>
            <i class="fa fa-utensils"></i>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required></textarea>
            <i class="fa fa-file-alt"></i>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" required>
            <i class="fa fa-indian-rupee-sign"></i>
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category" required>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
            </select>
        </div>
        <button type="submit">Add Dish</button>
    </form>

    <!-- Dish List -->
    <h3>Dish List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Dish Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM menu";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['dish_name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['category']}</td>
                        <td>
                            <a href='delete_dish.php?id={$row['id']}' class='delete-btn'
                               onclick='return confirm(\"Are you sure you want to delete this dish?\")'>
                               Delete
                            </a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
