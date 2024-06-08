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
    $stmt_select = $conn->prepare("SELECT id_paciente, nombre, apellido FROM paciente WHERE cedula = ?");
    $stmt_select->bind_param("s", $cedula_paciente);
    $stmt_select->execute();
    $stmt_select->bind_result($id_paciente, $nombre, $apellido);
    $stmt_select->fetch();
    $stmt_select->close();

    echo "<script>alert('. $id_paciente .');</script>";
    // Consulta preparada para insertar datos en paciente-visitas

?>



<?php
    $fecha_hoy =   //inserta fecha de hoy
    $stmt_insert = $conn->prepare("INSERT INTO `paciente-visitas` (id_paciente, nombre, apellido, cedula, id_user,fecha) VALUES (?, ?, ?, ?, ?, CURDATE())");
    $stmt_insert->bind_param("sssss", $id_paciente, $nombre, $apellido, $cedula_paciente, $id_doctor);

    if ($stmt_insert->execute()) {
        $stmt_insert->close();
        $conn->close();
        header("Location: consultaForm.php?insert_success=true");
        exit(); // Detiene la ejecución después de la redirección
    } else {
        $stmt_insert->close();
        $conn->close();
        echo "<script>alert('Error al ejecutar la consulta');</script>";
    }
}
?>
