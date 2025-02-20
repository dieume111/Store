<?php
session_start();
include("includes/config.php");

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM productin WHERE InID='$id'";

    if ($conn->query($sql)) {
        header("Location: view_stock.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
