<?php
$conn = new mysqli("localhost", "root", "", "ck");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file upload if present
    $image_url = $_POST['image_url'] ?? '';
    
    if (!empty($_FILES['image_upload']['name'])) {
        $upload_dir = 'uploads/';
        $file_name = uniqid() . '_' . basename($_FILES['image_upload']['name']);
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $target_path)) {
            $image_url = $target_path;
        }
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO menu (dish_name, description, price, category, image_url) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", 
        $_POST['dish_name'],
        $_POST['description'],
        $_POST['price'],
        $_POST['category'],
        $image_url
    );
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?success=1");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>