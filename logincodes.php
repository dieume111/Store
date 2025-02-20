<?php 
include 'dbconnection.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `users` WHERE UserName = '$username' AND Password = $password";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == true) {

     echo"LOGIN SUCCESSFULLY";
     header('Location: dashboard.php');
    }
    else{
        echo"invalid credentials";
    }
}
?>