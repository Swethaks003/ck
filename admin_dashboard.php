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

// Filter dishes by date (optional)
$filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
$filter_query = "SELECT * FROM menu";
if (!empty($filter_date)) {
    $filter_query .= " WHERE date_added = '$filter_date'";
}
$result = $conn->query($filter_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: 
            linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.1) 100%),
            url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1450&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.3);
            backdrop-filter:blur(5px);/* the background blurrness of the container */
        }

        h2, h3 {
            text-align: center;
            margin: 20px 0;
            color: #fff;
        }

        .logout-btn {
            text-align: right;
        }

        .logout-btn a {
            background: #ff4b5c;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .logout-btn a:hover {
            background: #e63946;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #fff;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: background 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            background: rgba(255, 255, 255, 0.3);
        }

        button {
            background: #00b4d8;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }

       
        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: separate;
            background: rgba(80, 80, 71, 0.3);
            background-color: rgba(17, 17, 17, 0.8);
            box-shadow: 0 0 10px rgba(0,0,0,0.2); 
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            color: #fff;
            transition: background 0.3s ease;
        }

        th {
            background: rgba(0, 180, 216, 0.8);
        }

        tr:hover {
            background: rgba(0, 255, 255, 0.3);
        }

        .delete-btn {
            background: #ff4b5c;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .delete-btn:hover {
            background: #c92a2a;
        }

        .filter-form {
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="logout-btn">
        <a href="logout.php">Logout</a>
    </div>

    <h3>Add New Dish</h3>
    <form action="add_dish.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Dish Name</label>
            <input type="text" name="dish_name" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category" required>
                <option value="Breakfast">Breakfast</option>
                <option value="Lunch">Lunch</option>
                <option value="Dinner">Dinner</option>
            </select>
        </div>

        <div class="form-group">
            <label>Image Upload</label>
            <input type="file" name="image_file">
            <p>OR</p>
            <label>Image URL</label>
            <input type="text" name="image_url" placeholder="https://example.com/image.jpg">
        </div>
        
            <a href="menu.php" target="_blank" style="background:rgb(103, 165, 28); color: white; padding: 10px 15px; text-decoration: none; border-radius: 8px; transition: background 0.3s ease;">Go to Menu</a>
        </div>


        
        <button type="submit">Add Dish</button>
    </form>

    <h3>Dish List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Dish Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['dish_name']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td>₹<?= $row['price']; ?></td>
                    <td><?= htmlspecialchars($row['category']); ?></td>
                    <td>
                        <?php if (!empty($row['image_path'])): ?>
                            <img src="<?= htmlspecialchars($row['image_path']); ?>" alt="<?= htmlspecialchars($row['dish_name']); ?>" style="width: 50px; height: 50px; object-fit: cover;">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                     </td>
                    <td>
                    
                        <a href="delete_dish.php?id=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this dish?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


</body>
</html>