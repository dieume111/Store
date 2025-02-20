<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
    exit();
}

include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Handle Add Product In
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete']) && !isset($_POST['update'])) {
    $pcode = $_POST['pcode'];
    // $pname = $_POST['pname'];
    $indate = $_POST['indate'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $total_price = $quantity * $unit_price;

    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO productin (PCode, InDate, InQuantity, InUnit_price, InTotal_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidd", $pcode, $indate, $quantity, $unit_price, $total_price);
    $stmt->execute();
    $stmt->close();
}

// Handle Deletion
if (isset($_POST['delete'])) {
    $pcode = $_POST['pcode'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM productin WHERE PCode = ?");
    $stmt->bind_param("s", $pcode);
    $stmt->execute();
    $stmt->close();

    // Redirect after deletion
    header("Location: productin.php");
    exit();
}

$sql= "SELECT * FROM products where PCode = ?";

// Handle Update Product
if (isset($_POST['update'])) {
    $pcode = $_POST['pcode'];
    // $pname = $_POST['pname'];
    $indate = $_POST['indate'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $total_price = $quantity * $unit_price;

    // Update product in the database
    $stmt = $conn->prepare("UPDATE productin SET InDate = ?, InQuantity = ?, InUnit_price = ?, InTotal_price = ? WHERE PCode = ?");
    $stmt->bind_param("siddi",  $indate, $quantity, $unit_price, $total_price, $pcode);
    $stmt->execute();
    $stmt->close();

    // Redirect after update
    header("Location: productin.php");
    exit();
}

// Fetch Product In Records with Product Name from products table
$productin = [];
$result = $conn->query("SELECT pi.PCode, p.Pname, pi.InDate, pi.InQuantity, pi.InUnit_price, pi.InTotal_price FROM productin pi JOIN products p ON pi.PCode = p.PCode");
while ($row = $result->fetch_assoc()) {
    $productin[] = $row;
}

// Handle Edit: Populate form with product data
$product = null;
if (isset($_GET['edit'])) {
    $pcode = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM productin WHERE PCode = ?");
    $stmt->bind_param("s", $pcode);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin-left: 250px;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1f2937;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 20px;
            z-index: 1000;
        }

        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        h2 {
            color: #1f2937;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        /* Form Styling */
        form {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 768px) {
            form {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4b5563;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        button {
            background: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        button:hover {
            background: #2563eb;
        }

        /* Table Styling */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #f8fafc;
            color: #4b5563;
            font-weight: 600;
        }

        tr:hover {
            background: #f8fafc;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .edit-btn {
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .delete-btn {
            background: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .edit-btn:hover {
            background: #059669;
        }

        .delete-btn:hover {
            background: #dc2626;
        }

        /* Form Card Styles */
        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-card h3 {
            color: #3b82f6;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        /* Submit Button Container */
        .submit-container {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    

<body>
    <div class="container">
        <?php if ($product): ?>
        <div class="form-card">
            <h3>Edit Product</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Product Code</label>
                    <input type="hidden" name="pcode" value="<?php echo htmlspecialchars($product['PCode']); ?>">
                    <input type="text" value="<?php echo htmlspecialchars($product['PCode']); ?>" disabled>
                </div>
                <!-- <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="pname" value="<?php echo htmlspecialchars($product['Pname']); ?>" required>
                </div> -->
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="indate" value="<?php echo htmlspecialchars($product['InDate']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['InQuantity']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" value="<?php echo htmlspecialchars($product['InUnit_price']); ?>" required>
                </div>
                <div class="submit-container">
                    <button type="submit" name="update">Update Product</button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <div class="form-card">
            <h3>Add New Product</h3>
            <form method="POST">
                <div class="form-group">
                    <label>Product Code</label>
                    <input type="number" name="pcode" placeholder="Enter product code" required>
                </div>
                <!-- <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="pname" placeholder="Enter product name" required>
                </div> -->
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="indate" required>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" placeholder="Enter quantity" required>
                </div>
                <div class="form-group">
                    <label>Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" placeholder="Enter unit price" required>
                </div>
                <div class="submit-container">
                    <button type="submit">Add Product</button>
                </div>
            </form>
        </div>

        <div class="card">
            <h3>Product List</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

            <?php foreach ($productin as $row): ?>
                <tr>
                    <td><?php echo $row['PCode']; ?></td>
                    <td><?php echo $row['Pname']; ?></td>
                    <td><?php echo $row['InDate']; ?></td>
                    <td><?php echo $row['InDate']; ?></td>
                    <td><?php echo $row['InQuantity']; ?></td>
                    <td><?php echo number_format($row['InUnit_price'], 2); ?></td>
                    <td><?php echo number_format($row['InTotal_price'], 2); ?></td>
                    <td>
                    <div class="action-buttons">
                                        <a href="productin.php?edit=<?php echo htmlspecialchars($row['PCode']); ?>" class="edit-btn">Edit</a>
                                        <form method="POST" style="display:inline; margin:0;">
                                            <input type="hidden" name="pcode" value="<?php echo htmlspecialchars($row['PCode']); ?>">
                                            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                        </form>
                                    </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
