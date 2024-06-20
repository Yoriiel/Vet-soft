

<!DOCTYPE html>
<html>
<style>
    .hidden {
        display: none;
    }
</style>

<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    include'header.php';
?>

<body id="page-top">
    <?php
    // Verificar si la actualización fue exitosa y mostrar la ventana emergente
    if (isset($_GET['update_success']) && $_GET['update_success'] == "true") {
        echo "<script>alert('Datos actualizados correctamente.');</script>";
    }
    ?>



    <div id="wrapper">
        <!--menu Vertical inicia-->
        <?php include('menu_v.php'); ?>
        <!--menu Vertical Termina-->

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
           
                <!--menu horizontal inicia-->
                <?php 
                    include 'barra.php';
                ?>
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
                                            <p class=" m-0 fw-bold" style="color: #228B22">Datos de <?php echo $_SESSION['role']; ?></p>
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
                                                    <div class="mb-3"><label class="form-label" for="first_name"><strong>Nombre</strong></label><input class="form-control" type="text" id="first_name" placeholder="<?php echo $firstName; ?>" name="first_name" readonly></div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3"><label class="form-label" for="last_name"><strong>Apellido</strong></label><input class="form-control" type="text" id="last_name" placeholder="<?php echo $lastName; ?>" name="last_name" readonly></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>