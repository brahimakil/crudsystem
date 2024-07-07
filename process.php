<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $taxes = isset($_POST['taxes']) ? (float)$_POST['taxes'] : 0;
    $ads = isset($_POST['ads']) ? (float)$_POST['ads'] : 0;
    $discount = isset($_POST['discount']) ? (float)$_POST['discount'] : 0;
    $total = $price + $taxes + $ads - $discount;
    $count = isset($_POST['count']) ? (int)$_POST['count'] : 1;
    $category = $_POST['category'];

    if ($id) {
        // Update existing product
        $stmt = $conn->prepare("UPDATE products SET title=?, price=?, taxes=?, ads=?, discount=?, total=?, count=?, category=? WHERE id=?");
        $stmt->bind_param("sdddddisi", $title, $price, $taxes, $ads, $discount, $total, $count, $category, $id);
    } else {
        // Insert new product
        $stmt = $conn->prepare("INSERT INTO products (title, price, taxes, ads, discount, total, count, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdddddis", $title, $price, $taxes, $ads, $discount, $total, $count, $category);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
