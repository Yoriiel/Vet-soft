<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';
?>

<body id="page-top">
    <?php
    include 'conexion.php';
    // Verificar si la actualización fue exitosa y mostrar la ventana emergente
    if (isset($_GET['update_success']) && $_GET['update_success'] == "true") {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Datos actualizados correctamente',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'profile.php';
                });
            </script>";
    }
    ?>



    <div id="wrapper">
        <!--menu Vertical inicia-->
        <?php include('menu_v.php'); ?>
        <!--menu Vertical Termina-->



        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <!--menu horizontal inicia-->
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="¿Que buscas?">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>

                            <div class="d-none d-sm-block topbar-divider"></div>
                            <!-- Usuario-->
                            <?php
                            include 'datos_generales.php';

                            ?>
                            <!-- Usuario-->


                        </ul>
                    </div>
                </nav>
                <!--menu horizontal termina-->
                <?php
                include 'conexion.php';
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] == UPLOAD_ERR_NO_FILE) {
                        echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No se ha cargado ninguna imagen'
                                }).then(function() {
                                    window.location.href = 'profile.php';
                                });
                            </script>";
                    } else {
                        $imagen = $_FILES["imagen"]["tmp_name"];
                        $imagenTipo = $_FILES["imagen"]["type"];
                        $imagenContenido = file_get_contents($imagen);
            
                        $sql_update = "UPDATE users SET imagen = ? WHERE id_user = ?";
                        $stmt_update = $conn->prepare($sql_update);
                        $stmt_update->bind_param("ss", $imagenContenido, $user_id);
                        $stmt_update->execute();


                    // Verificar si la inserción fue exitosa cuando se sube la imagen a la bd
                    if ($stmt_update->affected_rows > 0) {
                        //echo "La imagen se cargó correctamente en la base de datos.";
                        echo "
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Imagen actualizada correctamente',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                window.location.href = 'profile.php';
                            });
                        </script>";
                    } else {
                        echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al actualizar la imagen'
                            }).then(function() {
                                window.location.href = 'profile.php';
                            });
                        </script>";
                    }

                    // Cerrar la conexión
                    $stmt_update->close();
                    $conn->close();
                    exit();
                }
            }
                ?>
                <style>
                    .hidden {
                        display: none;
                    }
                </style>

                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Inicio</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <form method="post" enctype="multipart/form-data">
                                <div class="card mb-3">
                                    <div class="card-body text-center shadow"><img src="data:image/webp;base64,<?php echo base64_encode($imagenp); ?>" alt="Imagen" width="160" height="160">
                                        <div class="mb-3"><input type="file" name="imagen" accept="image/*"><button class="btn btn-primary btn-sm" type="submit">Cambiar foto</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold <?php echo $_SESSION['role'] !== 'medico' ? 'hidden' : ''; ?>">Datos del Doctor </p>
                                            <p class="text-primary m-0 fw-bold <?php echo $_SESSION['role'] !== 'secretaria' ? 'hidden' : ''; ?>">Datos de la Secretaria</p>
                                        </div>


                                        <div class="card-body">
                                            <form action="actualizar_datos.php" method="POST">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="username"><strong>ID-Doctor</strong></label><input class="form-control" type="text" id="username" placeholder="<?php echo $user_id; ?>" name="username" readonly></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="email"><strong>Correo Eléctronico</strong></label><input class="form-control" type="email" id="email" placeholder="<?php echo $eMail; ?>" name="email"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>Nombre</strong></label><input class="form-control" type="text" id="first_name" placeholder="<?php echo $firstName; ?>" name="first_name"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="last_name"><strong>Apellido</strong></label><input class="form-control" type="text" id="last_name" placeholder="<?php echo $lastName; ?>" name="last_name"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Actualizar Datos</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>