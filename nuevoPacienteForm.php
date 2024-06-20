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

include 'header.php';
?>

<body id="page-top">
    <?php

    // Verificar si la actualización fue exitosa y mostrar la ventana emergente
    if (isset($_GET['update_success']) && $_GET['update_success'] == "true") {
        echo "<script>alert('Datos insertados correctamente.');</script>";
    }
    ?>

    <div id="wrapper">
        <!--menu Vertical inicia-->
        <?php include('menu_v.php'); ?>
        <!--menu Vertical Termina-->

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">

                <!--menu horizontal inicia-->
                <?php include 'barra.php'; ?>
                <!--menu horizontal termina-->

                <style>
                    .contenedor {
                        max-width: 120rem;
                        width: 90%;
                        margin: 0 auto;
                    }
                </style>

                <div class="contenedor d-flex flex-column align-items-center  justify-content-center">
                    <form method="post" action="insertaPaciente.php">
                        <fieldset>
                            <legend style="text-align: center;">Formulario para Ingreso de Nuevo Paciente</legend>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="cedulaPaciente" class="form-label">Cédula</label>
                                    <input type="text" class="form-control" id="cedulaPaciente" name="cedula" required>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="nombrePaciente" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="apellidoPaciente" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="sexoPaciente" class="form-label">Sexo</label>
                                    <select class="form-control" id="sexo" name="sexo" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="telefonoPaciente" class="form-label">Teléfono/Celular</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="correoPaciente" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                </div>
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="residenciaPaciente" class="form-label">Residencia</label>
                                    <input type="text" class="form-control" id="residencia" name="residencia" required>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 mb-3 text-center">
                                    <label for="fechaNacPaciente" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha_nacimiento" required pattern="\d{4}-\d{2}-\d{2}">
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-md-6 mb-3 text-center">
                                    <button type="submit" class="btn" style="background-color:#228B22; color: white">Ingresar Nuevo Paciente</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div id="emailHelp" class="form-text text-center mt-3">No compartimos información con terceros</div>
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