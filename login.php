<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="icon" href="assets/img/avatars/avatar6.jpeg" sizes="16x16" type="image/png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="background: linear-gradient(0deg, #1A661A, #228B22)";>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/dogs/image2.jpg&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">¡Bienvenido a Vet-Soft!</h4>
                                    </div>
                                    <form class="user" method="POST" action="login-validation.php">
                                        <div class="mb-3"><input class="form-control form-control-user" type="text" id="email" aria-describedby="emailHelp" placeholder="Coloque su correo" name="email" required></div>
                                        <div class="mb-3"><input class="form-control form-control-user" type="password" id="password" placeholder="Contraseña" name="password" required></div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1"><label class="form-check-label custom-control-label" for="formCheck-1">Recordar correo</label></div>
                                            </div>
                                        </div><button class="btn d-block btn-user w-100" style="background-color: #228B22; color: white;" type="submit">Acceder</button>
                                    </form>
                                    <div class="text-center"><a class="small" href="forgot-password.html">Olvidaste la contraseña?</a></div>
                                    <div class="text-center"><a class="small" href="register.php">Crea una cuenta</a></div>
                                </div>
                            </div>
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