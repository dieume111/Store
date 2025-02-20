    <?php 
include("includes/config.php"); 
include("includes/header.php"); 
include("includes/sidebar.php"); 
?>

<div class="content" style="margin-left: 250px; padding: 20px;">
    <h2>View Stock</h2>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch stock data from the database
            $sql = "SELECT p.PCode, p.Pname, pi.InQuantity, pi.InUnit_price, pi.InTotal_price 
                    FROM productin pi 
                    JOIN products p ON pi.PCode = p.PCode";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["PCode"] . "</td>";
                    echo "<td>" . $row["Pname"] . "</td>";
                    echo "<td>" . $row["InQuantity"] . "</td>";
                    echo "<td>" . $row["InUnit_price"] . "</td>";
                    echo "<td>" . $row["InTotal_price"] . "</td>";
                    echo "<td>
                            <a href='edit_stock.php?id=" . $row["PCode"] . "'>Edit</a> | 
                            <a href='delete_stock.php?id=" . $row["PCode"] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include("includes/footer.php"); ?>
