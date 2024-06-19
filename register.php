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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-primary">
    <?php
    include 'conexion.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validación de datos
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        $password_repeat = $_POST['password_repeat'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];

        // Verificar que las contraseñas coincidan
        if ($password !== $password_repeat) {
            echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Las contraseñas no coinciden',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'register.php';
                });
            </script>";
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
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registrado',
                    text: 'Bienvenido a Medical-Soft',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'index.php';
                });
            </script>";
            exit;
        } else {
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No se ha registrar, verifique los datos'
                }).then(function() {
                    window.location.href = 'register.php';
                });
            </script>";
        }

        // Cerrar la conexión y liberar recursos
        $stmt->close();
        $conn->close();
    }
    ?>

    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;assets/img/dogs/image2.jpg&quot;);"></div>
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
