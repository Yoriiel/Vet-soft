<?php

#include("conexion.php");

#if ($_SERVER["REQUEST_METHOD"] == "POST") {
 #   $email = $_POST['email'];
  #  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  #  $sql = "INSERT INTO users (id_user ,email, password) VALUES ('2','$email', '$password')";

   # if (mysqli_query($conn, $sql)) {
    #    echo "Registration successful!";
     #   header("Location: index.php");
    #} else {
    #    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    #}
#}
include 'conexion.php';

echo "<script> alert('Ready pa la salsa'); </script>";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "<script> alert('Salseando'); </script>";
    // Validación de datos
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];

    // Verificar que las contraseñas coincidan
    if ($password !== $password_repeat) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Hash de la contraseña
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Sentencia preparada para la inserción
    $sql = "INSERT INTO users (email, password, firstname, lastname) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $hashedPassword, $firstName, $lastName);

    // Ejecutar la sentencia preparada
    if ($stmt->execute()) {
        echo "Registro Exitoso";
        header("Location: index.php");
        exit;
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Registro Medical-Soft</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;assets/img/dogs/image2.jpeg&quot;);"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Crea tu cuenta!</h4>
                            </div>
                            <form class="user" method="POST" action="register.php">
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Nombre" name="first_name" required></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Apellido" name="last_name" required></div>
                                </div>
                                <div class="mb-3"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Correo" name="email" required></div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Contraseña" name="password" required></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Repetir Contraseña" name="password_repeat" required></div>
                                </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Crear cuenta</button>
                                <hr><a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button"><i class="fab fa-google"></i>&nbsp; Crea la cuenta con Google</a><a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button"><i class="fab fa-facebook-f"></i>&nbsp; Register with Facebook</a>
                                <hr>
                            </form>
                            <div class="text-center"><a class="small" href="forgot-password.html">Olvidaste la contraseña?</a></div>
                            <div class="text-center"><a class="small" href="login.php">Ya tienes una cuenta? Inicia sesión!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>