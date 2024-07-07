<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if (!empty($id)) {
            $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } elseif (isset($_POST['deleteAll'])) {
        $sql = "DELETE FROM products";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
