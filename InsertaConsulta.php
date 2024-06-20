<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>

<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $cedula_paciente = $_POST['cedula_id'];
    $id_doctor = $_POST['iden'];

    // Consulta preparada para seleccionar datos del paciente
    $stmt_select = $conn->prepare("SELECT id_paciente, nombre, propietario FROM paciente WHERE cedula = ?");
    $stmt_select->bind_param("s", $cedula_paciente);
    $stmt_select->execute();
    $stmt_select->bind_result($id_paciente, $nombre, $apellido);
    $stmt_select->fetch();
    $stmt_select->close();

    if ($id_paciente != null) {
        // Consulta preparada para insertar datos en paciente-visitas
        $fecha_hoy =   //inserta fecha de hoy
            $stmt_insert = $conn->prepare("INSERT INTO `paciente-visitas` (id_paciente, nombre, propietario, cedula, id_user,fecha) VALUES (?, ?, ?, ?, ?, CURDATE())");
        $stmt_insert->bind_param("sssss", $id_paciente, $nombre, $propietario, $cedula_paciente, $id_doctor);

        if ($stmt_insert->execute()) {
            $stmt_insert->close();
            $conn->close();
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Consulta realizada exitosamente',
                    showConfirmButton: false,
                    timer: 2500
                }).then(function() {
                    window.location.href = 'consultas.php';
                });
            </script>";
            //echo "<script>window.location.href = 'consultas.php';</script>";
            //header("Location: consultaForm.php?insert_success=true");
            exit(); // Detiene la ejecución después de la redirección
        } else {
            $stmt_insert->close();
            $conn->close();
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error al ejecutar la consulta'
                }).then(function() {
                    window.location.href = 'consultas.php';
                });
            </script>";
            exit(); // Detiene la ejecución después de la redirección
        }
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'El paciente no existe',
                text: '¿Desea registrar un nuevo paciente?',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'nuevoPacienteForm.php';
                } else {
                    window.location.href = 'consultas.php';
                }
            });
        </script>";
        exit();
    }
}
?>

