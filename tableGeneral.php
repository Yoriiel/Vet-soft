

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

<body id="page-top">
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

                <!--inicia la tabla de los pacientes-->
                <!--Consulta SQL para obtener los datos de los pacientes-->
                <?php
                include 'conexion.php';

                //obtiene id del ususario logeado
                $user_id = $_SESSION['id'];

                // Consulta SQL para obtener el nombre completo del usuario
                $sql_user = "SELECT firstname, lastname FROM users WHERE id_user = ?";
                $stmt = $conn->prepare($sql_user);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->bind_result($firstName, $lastName);
                $stmt->fetch();
                $stmt->close();


                ?>

                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Dr. <?php echo $fullName; ?></h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Expediente del paciente</p>
                        </div>
                        <div class="card-body">
                            <style>
                                .container {
                                    display: flex;
                                }

                                .left {
                                    width: 30%;
                                }

                                .right {
                                    width: 70%;
                                    padding-left: 20px;
                                }

                                table {
                                    border-collapse: collapse;
                                    width: 100%;
                                }

                                th,
                                td {
                                    border: 1px solid black;
                                    padding: 8px;
                                    text-align: left;
                                }
                            </style>
                            <div class="container">
                                <div class="left">
                                    <?php
                                    // Consulta SQL para obtener los datos del expediente del paciente basado en la cédula
                                    if (isset($_GET['id_mascota'])) {
                                        $id_mascota = $_GET['id_mascota'];
                                        $sql_expediente = "SELECT `id_mascota`,`nombreMascota`,`duenoMascota`, `cedula`, `edadMascota`, `fechaNacimientoMascota`, `sexoMascota` FROM `paciente-expediente` WHERE id_mascota = ?";
                                        $stmt_expediente = $conn->prepare($sql_expediente);
                                        $stmt_expediente->bind_param("i", $id_mascota);
                                        $stmt_expediente->execute();
                                        $result_expediente = $stmt_expediente->get_result();
                                    }
                                    ?>

                                    <?php if (isset($result_expediente)) : ?>
                                        <table>
                                            <?php
                                            if ($result_expediente->num_rows <= 0) {
                                                echo "<tr><td colspan='2'>Aún no se ha generado un expediente</td></tr>";
                                            } else {
                                                // muestra los datos de la bd
                                                echo "<strong>Datos Generales</strong>";
                                                while ($row_expediente = $result_expediente->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<th>id_mascota</th>";
                                                    echo "<td>" . $row_expediente["id_mascota"] . "</td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                    echo "<th>Nombre de la mascota</th>";
                                                    echo "<td>" . $row_expediente["nombreMascota"] . "</td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                    echo "<th>Dueño de la mascota</th>";
                                                    echo "<td>" . $row_expediente["duenoMascota"] . "</td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                    echo "<th>Sexo</th>";
                                                    echo "<td>" . $row_expediente["sexoMascota"] . "</td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                    echo "<th>Edad</th>";
                                                    echo "<td>" . $row_expediente["edadMascota"] . "</td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                    echo "<th>Fecha de Nacimiento</th>";
                                                    echo "<td>" . $row_expediente["fechaNacimientoMascota"] . "</td>";
                                                    echo "</tr>";
                                                    
                                                   
                                                }
                                            }
                                            ?>
                                        </table>
                                    <?php endif; ?>
                                </div>
                                <div class="right">
                                    <?php
                                    // Consulta SQL para obtener los datos de las visitas de los pacientes según el médico seleccionado
                                    if (isset($_GET['id_mascota'])) {
                                        $id_mascota = $_GET['id_mascota'];
                                        $sql_visitas = "SELECT fecha, motivo, síntomas, diagnóstico,id_visita FROM `paciente-visitas` WHERE id_mascota = ?";
                                        $stmt_visitas = $conn->prepare($sql_visitas);
                                        $stmt_visitas->bind_param("i", $id_mascota);
                                        $stmt_visitas->execute();
                                        $result_visitas = $stmt_visitas->get_result();
                                    }
                                    if (isset($_GET['id_visita'])) {
                                        $id_visita = $_GET['id_visita'];
                                    }
                                    ?>

                                    <?php if (isset($result_visitas)) : echo  "<strong> Últimas visitas</strong>";?>
                                        <table>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Motivo</th>
                                                <th>Síntomas</th>
                                                <th>Diagnóstico</th>
                                                <th></th>
                                            </tr>
                                            <?php while ($row_visitas = $result_visitas->fetch_assoc()) : ?>
                                                <tr>
                                                    <td><?php echo $row_visitas["fecha"]; ?></td>
                                                    <td><?php echo $row_visitas["motivo"]; ?></td>
                                                    <td><?php echo $row_visitas["síntomas"]; ?></td>
                                                    <td><?php echo $row_visitas["diagnóstico"]; ?></td>
                                                    <td><a class="btn btn-primary" href="PDF.php?id=<?php echo $row_visitas['id_visita']; ?>">Ver más</a></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </table>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="container mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Generar Visita
        </button>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario para Nueva Visita de Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="post" action="insertaVisita.php?id_visita=<?php echo urlencode($id_visita); ?>">
                        <div class="mb-3">
                            <label for="cedulaPaciente" class="form-label">Motivo</label>
                            <input type="text" class="form-control" id="cedulaPaciente" name="motivo" required>
                        </div>
                        <div class="mb-3">
                            <label for="cedulaPaciente" class="form-label">Sintomas</label>
                            <input type="text" class="form-control" id="cedulaPaciente" name="sintomas" required>
                        </div>
                        <div class="mb-3">
                            <label for="cedulaPaciente" class="form-label">Diagnostico</label>
                            <input type="text" class="form-control" id="cedulaPaciente" name="diagnostico" required>
                        </div>
                        <div class="mb-3">
                            <label for="cedulaPaciente" class="form-label">Tratamiento</label>
                            <input type="text" class="form-control" id="cedulaPaciente" name="tratamiento" required>
                        </div>
                        <!-- Agrega aquí los demás campos del formulario -->
                        <button type="submit" class="btn btn-primary">Ingresar Paciente</button>
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