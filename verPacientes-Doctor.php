<?php
include 'conexion.php';

//obtiene id del ususario logeado
$user_id = $_SESSION['id'];

// Consulta SQL para obtener el nombre completo del usuario
$sql_user = "SELECT firstname, lastname FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName);
$stmt->fetch();
$stmt->close();

// Consulta SQL para obtener los datos de los pacientes visitas
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_doctor = $_POST['medico'];

    // Consulta preparada para seleccionar datos del paciente
    $sql = "SELECT nombre, apellido, cedula, motivo, fecha FROM `paciente-visitas` WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_doctor);
    $stmt->execute();
    $result = $stmt->get_result();
}
header('Location: table.php');
