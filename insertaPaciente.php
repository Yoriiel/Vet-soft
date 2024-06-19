<!DOCTYPE html>
<html>

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
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $sexo = $_POST['sexo'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $residencia = $_POST['residencia'];
        $fecha_nacimiento = date('Y-m-d', strtotime($_POST['fecha_nacimiento']));

        // Verificar si el paciente ya existe por cédula
        $stmt_check = $conn->prepare("SELECT id_paciente FROM paciente WHERE cedula = ?");
        $stmt_check->bind_param("s", $cedula);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Si el paciente existe, mostrar alerta y redirigir
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El paciente con esta cédula ya existe'
                }).then(function() {
                    window.location.href = 'consultas.php';
                });
            </script>";
            $stmt_check->close();
            exit();
        } else {
            $stmt_check->close();

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
                    echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                    icon: 'success',
                    title: 'Paciente agregado exitosamente',
                    showConfirmButton: false,
                    timer: 2500
                }).then(function() {
                    window.location.href = 'consultas.php';
                });
                </script>";
                    exit();
                } else {
                    echo "Error al ejecutar la consulta: " . $stmt_exped->error;
                }
                $stmt_exped->close();
            } else {
                echo "Error al ejecutar la consulta: " . $conn->error;
            }
        }
        $conn->close();
    }
    ?>
</body>

</html>