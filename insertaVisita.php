<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_visita'])) {
    $idvisita = $_GET['id_visita'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $motivo = $_POST['motivo'];
    $sintomas = $_POST['sintomas'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento']; // Asegúrate de que este campo esté en el formulario

    // Insertar los datos en la tabla paciente
    $stmt_vista = $conn->prepare("UPDATE `paciente-visitas` SET motivo=?, síntomas=?, diagnóstico=?, tratamiento=? WHERE id_visita=?");
    $stmt_vista->bind_param("sssss", $motivo, $sintomas, $diagnostico, $tratamiento, $idvisita);

    if ($stmt_vista->execute()) {
        echo "<script>alert('Paciente actualizado con éxito');</script>";
        header("Location:table.php");
        exit();
    } else {
        echo "Error al ejecutar la consulta: " . $stmt_vista->error;
    }
    $stmt_vista->close();
}
    $conn->close();
?>
