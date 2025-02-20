<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
    exit();
}
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Add a Product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pcode = $_POST['pcode'];
    $pname = $_POST['pname'];

    // Insert into the products table
    $stmt = $conn->prepare("INSERT INTO products (PCode, PName) VALUES (?, ?)");
    $stmt->bind_param("ss", $pcode, $pname);

    if ($stmt->execute()) {
        echo "<p>Product added successfully!</p>";
    } else {
        echo "<p>Error: Could not add product.</p>";
    }
    $stmt->close();
}

// Fetch Existing Products
$products = [];
$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Container styling */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

/* Heading styling */
h2 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 20px;
}

/* Form styling */
.form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}

.form input {
    width: 100%;
    max-width: 300px;
    padding: 10px;
    margin: 5px 0;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    width: 100%;
    max-width: 300px;
}

.form button:hover {
    background-color: #45a049;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    text-align: left;
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

    </style>
</head>
<body>
    


<div class="container">
    <h2>Manage Products</h2>
    <form method="POST" class="form">
        <input type="text" name="pcode" placeholder="Product Code" required>
        <input type="text" name="pname" placeholder="Product Name" required>
        <button type="submit">Add Product</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $row): ?>
                <tr>
                    <td><?php echo $row['PCode']; ?></td>
                    <td><?php echo $row['Pname']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>

