

<!DOCTYPE html>
<html>

<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

    include'header.php';
?>


                            <!-- Usuario-->
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

                                // Concatenar el nombre completo
                                $fullName = $firstName . " " . $lastName;

                                // Cerrar la conexión y liberar recursos
                                $stmt->close();
                                $conn->close();
                            ?>

<body id="page-top">
    <div id="wrapper">
    <?php include('menu_v.php'); ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                
                <!--menu horizontal inicia-->
                <?php 
                    include 'barra.php';
                ?>
                <!--menu horizontal termina-->

                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Consultas</h3>
                    </div>
                    <!--Aqui inician los botones de las actividades de la secretaria-->
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div>
                                                <a href="consultaForm.php" class="btn btn-primary">Nueva Consulta</a>
                                            </div>
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
                                        <div>
                                                <a href="nuevoPacienteForm.php" class="btn btn-primary">Nuevo Paciente</a>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!--   <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div>
                                                <a href="consulta_form.html" class="btn btn-primary">Programar Cita</a>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    
                    </div>
                    <!--Aqui terminan los botones de las actividades de la secretaria-->
                    <div class="row">
                        <div class="col-lg-7 col-xl-8">
                            <div class="card shadow mb-4">

                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                
                            </div>
                        </div>
                    </div>
            <!--    <div class="row">
                        <div class="col-lg-6 mb-4"></div>
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card textwhite bg-primary text-white shadow">
                                        <div class="card-body">
                                            <p class="m-0">Primary</p>
                                            <p class="text-white-50 small m-0">#4e73df</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card textwhite bg-success text-white shadow">
                                        <div class="card-body">
                                            <p class="m-0">Success</p>
                                            <p class="text-white-50 small m-0">#1cc88a</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card textwhite bg-info text-white shadow">
                                        <div class="card-body">
                                            <p class="m-0">Info</p>
                                            <p class="text-white-50 small m-0">#36b9cc</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card textwhite bg-warning text-white shadow">
                                        <div class="card-body">
                                            <p class="m-0">Warning</p>
                                            <p class="text-white-50 small m-0">#f6c23e</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card textwhite bg-danger text-white shadow">
                                        <div class="card-body">
                                            <p class="m-0">Danger</p>
                                            <p class="text-white-50 small m-0">#e74a3b</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card textwhite bg-secondary text-white shadow">
                                        <div class="card-body">
                                            <p class="m-0">Secondary</p>
                                            <p class="text-white-50 small m-0">#858796</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  -->
                    <?php
                                        include 'conteoPacientes.php';
                    ?>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Medical_Soft 2024</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>