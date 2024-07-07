<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Product Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2 class="subtitle">Product Management System</h2>
        <?php
        include 'config.php';

        $id = '';
        $title = '';
        $price = '';
        $taxes = '';
        $ads = '';
        $discount = '';
        $total = '';
        $count = '';
        $category = '';

        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $result = $conn->query("SELECT * FROM products WHERE id=$id") or die($conn->error);
            if ($result->num_rows) {
                $row = $result->fetch_array();
                $title = $row['title'];
                $price = $row['price'];
                $taxes = $row['taxes'];
                $ads = $row['ads'];
                $discount = $row['discount'];
                $total = $row['total'];
                $count = $row['count'];
                $category = $row['category'];
            }
        }
        ?>
        <form id="productForm" method="post" action="process.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" required>
            <div class="price-info">
                <input type="number" name="price" id="price" placeholder="Price" value="<?php echo $price; ?>" required>
                <input type="number" name="taxes" id="taxes" placeholder="Taxes" value="<?php echo $taxes; ?>">
                <input type="number" name="ads" id="ads" placeholder="Ads" value="<?php echo $ads; ?>">
                <input type="number" name="discount" id="discount" placeholder="Discount" value="<?php echo $discount; ?>">
                <input type="text" name="total" id="total" placeholder="Total" value="<?php echo $total; ?>" readonly>
            </div>
            <input type="number" name="count" id="count" placeholder="Count" value="<?php echo $count; ?>" required>
            <input type="text" name="category" id="category" placeholder="Category" value="<?php echo $category; ?>" required>
            <button type="submit" id="create"><?php echo $id ? 'Update' : 'Create'; ?></button>
        </form>
        <form id="searchForm">
            <input type="text" name="search" id="search" placeholder="Search">
            <!-- <div class="search-buttons">
                <button type="button" name="searchBy" value="title">Search By Title</button>
                <button type="button" name="searchBy" value="category">Search By Category</button>
            </div> -->
        </form>
        <button id="backButton" style="display: none;">Back</button>
        <div id="deleteAll">
            <?php
            if (isset($_GET['search']) && isset($_GET['searchBy'])) {
                $search = $_GET['search'];
                $searchBy = $_GET['searchBy'];
                $sql = "SELECT * FROM products WHERE $searchBy LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM products";
            }

            $result = $conn->query($sql);
            $productCount = $result->num_rows;

            if ($productCount > 0) {
                echo "<form method='post' action='delete.php'>
                        <button type='submit' name='deleteAll'>Delete All ($productCount)</button>
                      </form>";
            }
            ?>
        </div>
        <div id="searchResults">
            <!-- Search results will be displayed here -->
        </div>
        <table id="productTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Taxes</th>
                    <th>Ads</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Category</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
            </tbody>
        </table>
    </div>
    <script src="script.js"></script>
</body>
</html>
