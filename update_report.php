<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $result = $conn->query("SELECT * FROM productin WHERE InID='$id'");
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $PCode = $_POST["PCode"];
    $InQuantity = $_POST["InQuantity"];
    $InUnit_price = $_POST["InUnit_price"];
    $InTotal_price = $InQuantity * $InUnit_price;

    $sql = "UPDATE productin SET PCode='$PCode', InQuantity='$InQuantity', InUnit_price='$InUnit_price', InTotal_price='$InTotal_price' WHERE InID='$id'";

    if ($conn->query($sql)) {
        header("Location: view_stock.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<?php 
include("includes/config.php"); 
include("includes/header.php"); 
include("includes/sidebar.php"); 
?>

<h2>Update Stock Record</h2>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $row['InID']; ?>">
    <input type="number" name="PCode" value="<?php echo $row['PCode']; ?>" required>
    <input type="number" name="InQuantity" value="<?php echo $row['InQuantity']; ?>" required>
    <input type="text" name="InUnit_price" value="<?php echo $row['InUnit_price']; ?>" required>
    <button type="submit">Update Stock</button>
</form>
<a href="view_stock.php">Cancel</a>
