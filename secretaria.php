<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Profile - Medical_Soft</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
</head>

<body id="page-top">
        <?php
            // Verificar si la actualización fue exitosa y mostrar la ventana emergente
            if (isset($_GET['update_success']) && $_GET['update_success'] == "true") {
                echo "<script>alert('Datos actualizados correctamente.');</script>";
            }
        ?>



    <div id="wrapper">
        <!--menu vertical inicia-->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-briefcase-medical"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Medical_Soft</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="secretaria.php"><i class="fa fa-user-md"></i><span>Inicio</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="consultas.php"><i class="fas fa-table"></i><span>Consulta</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="table.php"><i class="fas fa-user-friends"></i><span>Pacientes por Atender</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="cerrar_sesion.php"><i class="fas fa-external-link-alt"></i><span>Salir</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <!--menu vertical termina-->
        
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <!--menu horizontal inicia-->
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="¿Que buscas?"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                        </form>
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
                                include 'datos_doctor.php';
                              ?>
                            
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $fullName;?></span><img class="border rounded-circle img-profile" src="data:image/webp;base64,<?php echo base64_encode($imagenp); ?>"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a><a class="dropdown-item" href="profile.php"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Configuración</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="cerrar_sesion.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Cerrrar Sesión</a>
                                    </div>
                                </div>
                            </li>
                            <!-- Usuario-->

                        </ul>
                    </div>
                </nav>
                <!--menu horizontal termina-->
              
                
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Inicio</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                               
                                        <div class="card mb-3">
                                            <div class="card-body text-center shadow"><img src="data:image/webp;base64,<?php echo base64_encode($imagenp); ?>" alt="Imagen" width="160" height="160" style="border-radius: 50%;">
                                                
                                            </div>
                                        </div>
                        
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Datos de la secretaria</p>
                                        </div>
                                        
                                        <?php
                                            include 'conexion.php';
                                           

                                            // Suponiendo que tengas el ID del usuario almacenado en alguna variable
                                            $user_id = $_SESSION['id']; // Por ejemplo, supongamos que almacenaste el ID del usuario en una variable de sesión

                                            // Consulta SQL para obtener el nombre completo del usuario
                                            $sql = "SELECT firstname, lastname FROM users WHERE id_user = ?"; // Ajusta la consulta según la estructura de tu base de datos
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $user_id);
                                            $stmt->execute();
                                            $stmt->bind_result($firstName, $lastName);
                                            $stmt->fetch();
                                            // Cerrar la conexión y liberar recursos
                                            $stmt->close();
                                            $conn->close();
                                            
                                        ?>
                                        <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="first_name"><strong>Nombre</strong></label><input class="form-control" type="text" id="first_name" placeholder="<?php echo $firstName;?>" name="first_name"readonly></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3"><label class="form-label" for="last_name"><strong>Apellido</strong></label><input class="form-control" type="text" id="last_name" placeholder="<?php echo $lastName;?>" name="last_name" readonly></div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        include 'conexion.php';

                        // Consulta SQL para obtener la cantidad de pacientes por atender
                        $sql_pacientes = "SELECT COUNT(*) AS total_pacientes FROM `paciente-visitas`";
                        $stmt_pacientes = $conn->prepare($sql_pacientes);
                        $stmt_pacientes->execute();
                        $stmt_pacientes->bind_result($total_pacientes);
                        $stmt_pacientes->fetch();
                        $stmt_pacientes->close();

                    ?>
                    <?php
                        include 'conexion.php';

                        // Consulta SQL para obtener la cantidad de pacientes por atender
                        $sql_medicos ="SELECT COUNT(*) AS total_medicos FROM `users` WHERE rol = 'medico'";
                        $stmt_medicos = $conn->prepare($sql_medicos);
                        $stmt_medicos->execute();
                        $stmt_medicos->bind_result($total_medicos);
                        $stmt_medicos->fetch();
                        $stmt_medicos->close();

                    ?>

                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-warning py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Consultas Generadas</span></div>
                                                    <!-- Mostrar la cantidad de pacientes por atender-->
                                                    <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pacientes . '</span></div>'; ?>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Cantidad de Doctores</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                <?php echo '<div class="text-dark fw-bold h5 mb-0 me-3"><span>' . $total_medicos . '</span></div>'?>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"><span class="visually-hidden">80%</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-pills fa-2x text-gray-300"></i></div>
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