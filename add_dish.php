<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "ck");

    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // Get input values
    $dish_name = $conn->real_escape_string($_POST['dish_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $category = $conn->real_escape_string($_POST['category']);

    // Initialize image path
    $image_path = '';

    // Ensure uploads directory exists
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Create directory if it doesn't exist
    }

    // Handle image upload - either through file upload or URL
    if (isset($_FILES['image_file']) && !empty($_FILES['image_file']['name'])) {
        $target_file = $target_dir . basename($_FILES['image_file']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['image_file']['tmp_name']);
        if ($check !== false) {
            // If move_uploaded_file returns false, the upload has failed
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                $image_path = $target_file; // Save the path
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit(); // Exit if upload fails
            }
        }
    } elseif (!empty($_POST['image_url'])) {
        $image_path = $conn->real_escape_string($_POST['image_url']); // Use the provided URL
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO menu (dish_name, description, price, category, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $dish_name, $description, $price, $category, $image_path);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php"); // Redirect to dashboard after success
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>