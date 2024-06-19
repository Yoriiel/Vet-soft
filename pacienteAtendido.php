<!--Conexion a la base de datos 'medical'-->
<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

?>

<?php

include 'conexion.php';
if (isset($_GET['cedula'])) {

    $cedula = $_GET['cedula'];
    $statuss = 1; // Cambié esto para usar una variable en lugar de un valor directo
    $sql_statuss = "UPDATE `paciente-visitas` SET statuss = ? WHERE cedula = ?";
    $stmt_statuss = $conn->prepare($sql_statuss);
    $stmt_statuss->bind_param("is", $statuss, $cedula); // 'i' para entero, 's' para cadena
    $stmt_statuss->execute();

    header("Location: table.php");

    $stmt_statuss->close();
    $conn->close();
}
?>