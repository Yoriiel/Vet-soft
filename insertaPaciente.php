<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $sexo = $_POST['sexo'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $residencia = $_POST['residencia'];
    $fecha_nacimiento = date('Y-m-d', strtotime($_POST['fecha_nacimiento']));

    // Insertar los datos en la tabla paciente
    $stmt = $conn->prepare("INSERT INTO paciente (nombre, apellido, sexo, correo, telefono, residencia, fecha_nacimiento, cedula) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nombre, $apellido, $sexo, $correo, $telefono, $residencia, $fecha_nacimiento, $cedula);

    if ($stmt->execute()) {
        $stmt->close();

        // Recuperar el id del paciente recién insertado
        $stmt_pace = $conn->prepare("SELECT id_paciente FROM paciente WHERE cedula = ?");
        $stmt_pace->bind_param("s", $cedula);
        $stmt_pace->execute();
        $stmt_pace->bind_result($id_paciente_ex);
        $stmt_pace->fetch();
        $stmt_pace->close();

        // Insertar los datos en la tabla paciente-expediente
        $stmt_exped = $conn->prepare("INSERT INTO `paciente-expediente` (id_paciente, nombre, apellido, genero, correo, telefono, residencia, fechaDeNacimiento, cedula) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_exped->bind_param("issssssss", $id_paciente_ex, $nombre, $apellido, $sexo, $correo, $telefono, $residencia, $fecha_nacimiento, $cedula);

        if ($stmt_exped->execute()) {
            echo "<script>alert('Paciente actualizado con éxito');</script>";
            header("Location: nuevoPacienteForm.php?insert_success=true");
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . $stmt_exped->error;
        }
        $stmt_exped->close();
    } else {
        echo "Error al ejecutar la consulta: " . $conn->error;
    }
    $conn->close();
}
?>

