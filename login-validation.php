<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])&& $row['rol']=="medico") {
            $_SESSION['email']= $row['email'];
            $_SESSION['id']= $row['id_user'];
            $_SESSION['role']= $row['rol'];
            header("Location: index.php");
        } 
        else if(password_verify($password, $row['password'])&& $row['rol']=="secretaria") {
            $_SESSION['email']= $row['email'];
            $_SESSION['id']= $row['id_user'];
            $_SESSION['role']= $row['rol'];
            header("Location: index.php");
            
        }
        else{
            echo "Invalid password";
        }
    } else {
        echo "No user found";
    }
}
?>
