<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
    exit();
}

include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';

try {
    // Query for daily product in
    $stmt_in = $conn->query("SELECT p.PName, pi.PCode, pi.InDate, pi.InQuantity, pi.InUnit_price, pi.InTotal_price 
                             FROM productin pi 
                             JOIN products p ON pi.PCode = p.PCode 
                             WHERE InDate = CURDATE()");
    if (!$stmt_in) {
        throw new Exception("Error fetching daily product in records.");
    }
    $daily_in = [];
    while ($row = $stmt_in->fetch_assoc()) {
        $daily_in[] = $row;
    }

    // Query for daily product out
    $stmt_out = $conn->query("SELECT p.PName, po.PCode, po.OutDate, po.OutQuantity, po.OutUnit_price, po.OutTotal_price 
                              FROM productout po 
                              JOIN products p ON po.PCode = p.PCode 
                              WHERE OutDate = CURDATE()");
    if (!$stmt_out) {
        throw new Exception("Error fetching daily product out records.");
    }
    $daily_out = [];
    while ($row = $stmt_out->fetch_assoc()) {
        $daily_out[] = $row;
    }

    // Query for monthly product in
    $stmt_in_month = $conn->query("SELECT p.PName, pi.PCode, pi.InDate, pi.InQuantity, pi.InUnit_price, pi.InTotal_price 
                                   FROM productin pi 
                                   JOIN products p ON pi.PCode = p.PCode 
                                   WHERE MONTH(InDate) = MONTH(CURDATE()) AND YEAR(InDate) = YEAR(CURDATE())");
    if (!$stmt_in_month) {
        throw new Exception("Error fetching monthly product in records.");
    }
    $monthly_in = [];
    while ($row = $stmt_in_month->fetch_assoc()) {
        $monthly_in[] = $row;
    }

    // Query for monthly product out
    $stmt_out_month = $conn->query("SELECT p.PName, po.PCode, po.OutDate, po.OutQuantity, po.OutUnit_price, po.OutTotal_price 
                                    FROM productout po 
                                    JOIN products p ON po.PCode = p.PCode 
                                    WHERE MONTH(OutDate) = MONTH(CURDATE()) AND YEAR(OutDate) = YEAR(CURDATE())");
    if (!$stmt_out_month) {
        throw new Exception("Error fetching monthly product out records.");
    }
    $monthly_out = [];
    while ($row = $stmt_out_month->fetch_assoc()) {
        $monthly_out[] = $row;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-left: 260px;
            padding: 20px;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #444;
        }
        h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }
        .no-data {
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Reports</h2>

    <!-- Daily Report Section -->
    <h3>Daily Reports - Product In</h3>
    <?php if (empty($daily_in)): ?>
        <p class="no-data">No products in today.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daily_in as $row): ?>
                    <tr>
                        <td><?php echo $row['PCode']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['InDate']; ?></td>
                        <td><?php echo $row['InQuantity']; ?></td>
                        <td><?php echo $row['InUnit_price']; ?></td>
                        <td><?php echo $row['InTotal_price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h3>Daily Reports - Product Out</h3>
    <?php if (empty($daily_out)): ?>
        <p class="no-data">No products out today.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daily_out as $row): ?>
                    <tr>
                        <td><?php echo $row['PCode']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['OutDate']; ?></td>
                        <td><?php echo $row['OutQuantity']; ?></td>
                        <td><?php echo $row['OutUnit_price']; ?></td>
                        <td><?php echo $row['OutTotal_price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Monthly Report Section -->
    <h3>Monthly Reports - Product In</h3>
    <?php if (empty($monthly_in)): ?>
        <p class="no-data">No products in this month.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly_in as $row): ?>
                    <tr>
                        <td><?php echo $row['PCode']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['InDate']; ?></td>
                        <td><?php echo $row['InQuantity']; ?></td>
                        <td><?php echo $row['InUnit_price']; ?></td>
                        <td><?php echo $row['InTotal_price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h3>Monthly Reports - Product Out</h3>
    <?php if (empty($monthly_out)): ?>
        <p class="no-data">No products out this month.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthly_out as $row): ?>
                    <tr>
                        <td><?php echo $row['PCode']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['PName']; ?></td>
                        <td><?php echo $row['OutDate']; ?></td>
                        <td><?php echo $row['OutQuantity']; ?></td>
                        <td><?php echo $row['OutUnit_price']; ?></td>
                        <td><?php echo $row['OutTotal_price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>