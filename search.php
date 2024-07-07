<?php
include 'config.php';

$search = $_GET['search'] ?? '';
$searchBy = $_GET['searchBy'] ?? 'title' ; // Default search by title

$sql = "SELECT * FROM products WHERE $searchBy LIKE '%$search%'";
$result = $conn->query($sql);
$productCount = $result->num_rows;

if ($productCount > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['price']}</td>
                <td>{$row['taxes']}</td>
                <td>{$row['ads']}</td>
                <td>{$row['discount']}</td>
                <td>{$row['total']}</td>
                <td>{$row['category']}</td>
                <td>
                    <form method='get' action='index.php'>
                        <input type='hidden' name='edit' value='{$row['id']}'>
                        <button type='submit'>Update</button>
                    </form>
                </td>
                <td>
                    <form method='post' action='delete.php'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</button>
                    </form>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='10'>No products found</td></tr>";
}

$conn->close();
?>
