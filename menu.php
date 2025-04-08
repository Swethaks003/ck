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
    <title>Cloud Kitchen - Delicious Food Delivered</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #ff5722;
            --secondary: #ff7043;
            --accent: #ffab91;
            --dark: #222;
            --success: #4caf50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1592457711340-2412dc07b733?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aW5kaWFuJTIwc3BpY2VzfGVufDB8fDB8fHww');
            background-size: cover;
            background-position: center;
            color:white;
            min-height: 100vh;
        }

        header {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn {
            background: white;
            color: var(--primary);
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s ease;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }

        .btn:hover {
            background: var(--secondary);
            color: white;
            transform: scale(1.05);
        }

        main {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .section-title {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #fff;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 0.5rem auto 0;
            border-radius: 2px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .menu-card {
            background: rgba(27, 2, 2, 0.95);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(241, 240, 241, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color:gold;/*heading*/
            font-size: larger;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(248, 246, 246, 0.25);/*when clicked on the box*/
        }

        .card-img {
            height: 200px; /*image card in the login page*/
            width:100%;
            object-fit: cover;
        }

        .card-body {
            padding: 1.2rem;
            display: flex;
            flex-direction: column; /* Stacks elements vertically */
            height: 100%;
        }

        .card-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-style: bold;
        }

        .card-text {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 1rem;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
        }

        .price {
            font-weight: 600;
            color: var(--success);
        }

        .category {
            background: var(--accent);
            color: red;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        .about {
            background: rgba(0, 0, 0, 0.4);
            padding: 3rem 2rem;
            position:center;
            margin: 3rem 0;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .feature i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        footer {
            background: #111;
            color: #ccc;
            padding: 3rem 1rem;
            text-align: center;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .social-links a {
            color: white;
            font-size: 1.3rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--accent);
        }

        .contact-info i {
            margin-right: 0.5rem;
            color: var(--accent);
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
            }
            .menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <i class="fas fa-utensils"></i>
            <span>Cloud Kitchen</span>
        </div>
        <a href="admin_login.php" class="btn">
            <i class="fas fa-lock"></i> Admin Login
        </a>
    </header>
    <!-- Main Content -->
<main>
    <?php
    $categories = ['Breakfast', 'Lunch', 'Dinner'];
    foreach ($categories as $category) {
        echo "<h2 class='section-title'>$category</h2>";
        echo "<div class='menu-grid'>";
    
        $query = "SELECT * FROM menu WHERE category = '$category'";
        $result = $conn->query($query);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!empty($row['image_path'])) {
                    $imageUrl = $row['image_path'];
                } else {
                    $dish = urlencode(strtolower($row['dish_name']));
                    $imageUrl = "https://source.unsplash.com/400x300/?$dish,food";
                }
    
                echo "
                <div class='menu-card'>
                    <img src='$imageUrl' alt='{$row['dish_name']}' class='card-img' onerror=\"this.onerror=null;this.src='default.jpg';\">
                    <div class='card-body'>
                        <h3 class='card-title'>{$row['dish_name']}</h3>
                        <p class='card-text'>{$row['description']}</p>
                        <div class='card-footer'>
                            <span class='price'>₹{$row['price']}</span>
                            <span class='category'>{$row['category']}</span>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p style='grid-column: 1/-1; text-align: center;'>No dishes available for $category.</p>";
        }
    
        echo "</div>";
    }
    ?>
</main>

    <!-- About Section -->
    <section class="about">
        <h2 class="section-title">About Us</h2>
        <p>Welcome to Cloud Kitchen, where culinary excellence meets convenience! We deliver restaurant-quality meals straight to your door.</p>

        <div class="feature">
            <i class="fas fa-leaf"></i>
            <div>
                <h3>Fresh Ingredients</h3>
                <p>Only the freshest ingredients, locally sourced and handpicked.</p>
            </div>
        </div>

        <div class="feature">
            <i class="fas fa-calendar-alt"></i>
            <div>
                <h3>Daily Menus</h3>
                <p>Enjoy new flavors every day curated by our expert chefs.</p>
            </div>
        </div>

        <div class="feature">
            <i class="fas fa-wallet"></i>
            <div>
                <h3>Affordable Prices</h3>
                <p>Delicious dishes at prices that suit your wallet.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="logo">
            <i class="fas fa-cloud-meatball"></i>
            <span>Cloud Kitchen</span>
        </div>
        <p>Delivering deliciousness since 2023</p>

        <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
        </div>

        <div class="contact-info">
            <p><i class="fas fa-envelope"></i> info@cloudkitchen.com</p>
            <p><i class="fas fa-phone"></i> (123) 456-7890</p>
            <p><i class="fas fa-clock"></i> Open daily 8AM - 10PM</p>
        </div>

        <p>&copy; 2023 Cloud Kitchen. All rights reserved.</p>
    </footer>
</body>
</html>