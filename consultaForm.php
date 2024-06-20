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
                <?php include 'barra.php'; ?>
                <!--menu horizontal termina-->

                <!--Inicio del formulario para nuevo paciente-->
                <style>
                    .contenedor {
                        max-width: 120rem;
                        width: 90%;
                        margin: 0 auto;
                    }
                </style>
                <div class="contenedor d-flex flex-column align-items-center  justify-content-center">
                    <form action="InsertaConsulta.php" method="post">
                        <fieldset>
                            <legend>Generar Consulta</legend>
                            <div class="mb-3">
                                <label for="disabledTextInput" class="form-label">Mascotas</label>
                                <select id="paciente_id" name="iden" class="form-select">
                                    <!--form para nueva consulta-->
                                    <?php
                                    include 'conexion.php';
                                    if(isset($_GET['cedulaPropietario'])){
                                        $cedulaPropietario = $_GET['cedulaPropietario'];

                                    }
                                    $sqlCedula = "SELECT nombre FROM pacientes WHERE cedulaPropietario = ?";
                                    $stmt_cedula = $conn->prepare($sqlCedula);
                                    $stmt_cedula->bind_param("s", $cedulaPropietario);
                                    $stmt_cedula->execute();
                                    $stmt_cedula->bind_result($nombrePac);
                                    $stmt_cedula->fetch();
                                    $stmt_cedula->close();
                                    /********************************************** */
                                    $us_id = $_SESSION['id'];
                                    $sql_clin = "SELECT clinica FROM users WHERE id_user = ?"; // Ajusta la consulta según la estructura de tu base de datos
                                    $stmt_clin = $conn->prepare($sql_clin);
                                    $stmt_clin->bind_param("i", $us_id);
                                    $stmt_clin->execute();
                                    $stmt_clin->bind_result($clinics);
                                    $stmt_clin->fetch();
                                    $stmt_clin->close();

                                    //Separacion de consultas

                                    $sql = "SELECT firstname, lastname,id_user FROM users WHERE rol = 'medico' AND clinica =?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $clinics);
                                    $stmt->execute();
                                    $stmt->bind_result($doctores, $apellido, $id);


                                    while ($stmt->fetch()) {
                                        echo "<option value=\"$id\"> $doctores $apellido ($id)</option>";
                                    }
                                    $stmt->close();

                                    ?>
                            </div>

                            <div class="mb-3">
                                <!-------------------------------------------------------------------->
                                <label for="disabledSelect" class="form-label">Doctor</label>
                                <select id="paciente_id" name="iden" class="form-select">
                                    <!--form para nueva consulta-->
                                    <?php
                                    include 'conexion.php';
                                    $us_id = $_SESSION['id'];
                                    $sql_clin = "SELECT clinica FROM users WHERE id_user = ?"; // Ajusta la consulta según la estructura de tu base de datos
                                    $stmt_clin = $conn->prepare($sql_clin);
                                    $stmt_clin->bind_param("i", $us_id);
                                    $stmt_clin->execute();
                                    $stmt_clin->bind_result($clinics);
                                    $stmt_clin->fetch();
                                    $stmt_clin->close();

                                    //Separacion de consultas

                                    $sql = "SELECT firstname, lastname,id_user FROM users WHERE rol = 'medico' AND clinica =?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $clinics);
                                    $stmt->execute();
                                    $stmt->bind_result($doctores, $apellido, $id);


                                    while ($stmt->fetch()) {
                                        echo "<option value=\"$id\"> $doctores $apellido ($id)</option>";
                                    }
                                    $stmt->close();

                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn" style="background-color:#228B22; color: white">Generar</button>
                        </fieldset>
                    </form>

                </div>

                <div id="emailHelp" class="form-text text-center">No compartimos información con terceros</div>
                <!--Termina formulario-->

            </div>
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