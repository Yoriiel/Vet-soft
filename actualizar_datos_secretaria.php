
<?php
session_start();
include 'conexion.php';

// Verificar si se ha enviado un formulario POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Suponiendo que tengas el ID del usuario almacenado en alguna variable de sesión
    $user_id = $_SESSION['id']; // Ajusta esto según cómo manejas el ID del usuario

    // Consulta SQL para obtener los datos actuales del usuario
    $sql = "SELECT email, firstname, lastname FROM users WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($current_email, $current_first_name, $current_last_name);
    $stmt->fetch();
    $stmt->close();

    // Recuperar los datos del formulario
    $email = !empty($_POST['email']) ? $_POST['email'] : $current_email;
    $first_name = !empty($_POST['first_name']) ? $_POST['first_name'] : $current_first_name;
    $last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : $current_last_name;

    // Consulta SQL para actualizar los datos del usuario
    $sql_update = "UPDATE users SET email = ?, firstname = ?, lastname = ? WHERE id_user = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $email, $first_name, $last_name, $user_id);
    // Ejecutar la consulta SQL de actualización
    if ($stmt_update->execute()) {
        
        // La actualización fue exitosa
        header("Location: profile.php?update_success=true");
            exit();
    } else {
        // Hubo un error en la actualización
        echo "Error al actualizar los datos: " . $stmt_update->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt_update->close();
    $conn->close();
} else {
    // Si no se recibió una solicitud POST, redirigir a alguna página apropiada
    header("Location: index.php");
    exit();
}

?>
