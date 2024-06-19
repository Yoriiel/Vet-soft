

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

                $medico_id = $user_id;
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['medico'])) {
                        $medico_id = $_POST['medico'];
                    }
                }

                // Consulta SQL para obtener los datos de los pacientes visitas según el médico seleccionado
                
                $sql = "SELECT nombre, apellido, cedula, motivo, fecha, statuss, id_visita FROM `paciente-visitas` WHERE id_user = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $medico_id);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <div class="container-fluid">
                    
                <?php

                    // Obtener el rol y el nombre completo desde la sesión y la base de datos
                    $role = $_SESSION['role'];
                    // Determinar el prefijo basado en el rol
                    $prefix = '';
                    if ($role == 'medico') {
                    $prefix = 'Dr. ';
                    } elseif ($role == 'secretaria') {
                    $prefix = 'Sria. ';
                    }
                    ?>

                    <h3 class="text-dark mb-4"> <?php echo $prefix . $fullName; ?></h3>

                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Pacientes por atender <?php include 'fecha.php';
                                                                                        echo $fecha; ?></p>
                        </div>
                        <?php if ($_SESSION['role'] == 'secretaria') : ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 text-nowrap">
                                        <!--esta controla el menu desplegable-->
                                        <div class="mb-3">

                                            <?php

                                            $fullNameM = '';

                                            // Consulta SQL para obtener el nombre completo del usuario
                                            $sql = "SELECT firstname, lastname FROM users WHERE id_user = ?"; // Ajusta la consulta según la estructura de tu base de datos
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $medico_id);
                                            $stmt->execute();
                                            $stmt->bind_result($firstNameM, $lastNameM);
                                            $stmt->fetch();

                                            // Concatenar el nombre completo

                                            $fullNameM = $firstNameM . " " . $lastNameM;

                                            // Cerrar la conexión y liberar recursos
                                            $stmt->close();
                                            $conn->close();
                                            ?>
                                            <label for="disabledSelect" class="form-label">Ver Pacientes para el Dr. <?php echo  $fullNameM; ?></label>
                                            <!--form para nueva consulta-->
                                            <form action="" class="d-flex gap-2" method="post">
                                                <select id="paciente_id" name="medico" class="form-select">
                                                    <option>Selecciona Médico</option>

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
                   

                   

                    // Utilizamos un marcador de posición en la consulta SQL
                    $sql = "SELECT firstname, lastname, id_user FROM users WHERE rol = 'medico' AND clinica = ?";

                    if ($stmt = $conn->prepare($sql)) {
                        // Vinculamos el parámetro
                        $stmt->bind_param("s", $clinics); // "i" indica que el parámetro es un entero
                        
                        // Ejecutamos la consulta
                        $stmt->execute();
                        
                        // Vinculamos las variables de resultado
                        $stmt->bind_result($doctores, $apellido, $id);
                        
                        // Iteramos sobre los resultados
                        while ($stmt->fetch()) {
                            echo "<option value=\"$id\"> $doctores $apellido ($id)</option>";
                        }
                        
                        // Cerramos la declaración
                        $stmt->close();
                    } else {
                        // Manejo de errores en caso de que la declaración no se prepare correctamente
                        echo "Error en la preparación de la declaración: " . $conn->error;
                    }
                    ?>

                                                </select>
                                                <button type="submit" class="btn btn-primary">Ver</button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                    <table class="table my-0" id="dataTable">
                                        <thead>
                                            <tr>
                                                
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Cédula</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if ($result->num_rows > 0) {
                                                // muestra los datos de la bd
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["statuss"] == 0) {
                                                       
                                                        echo "<td>" . $row["nombre"] . "</td><td>" . $row["apellido"] . "</td><td>" . $row["cedula"] . "</td><td>" . $row["fecha"] . "</td>";
                                                        
                                                        echo "</tr>";
                                                    }
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No hay datos</td></tr>";
                                            }
                                            $conn->close();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php elseif ($_SESSION['role'] == 'medico') : ?>
                            
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Cédula</th>
                                            <th>Motivo</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($result->num_rows > 0) {
                                            // muestra los datos de la bd
                                            while ($row = $result->fetch_assoc()) {
                                                if ($row["statuss"] == 0) {
                                                    echo '<tr><td><a href="pacienteAtendido.php?cedula=' . $row["cedula"] . '" class="btn btn-primary btn-sm">Atendido</a></td>';
                                                    echo "<td>" . $row["nombre"] . "</td><td>" . $row["apellido"] . "</td><td>" . $row["cedula"] . "</td><td>" . $row["motivo"] . "</td><td>" . $row["fecha"] . "</td>";
                                                    echo '<td><a href="tableGeneral.php?cedula=' . $row["cedula"] . '&id_visita=' . $row["id_visita"] . '" class="btn btn-primary btn-sm">Ver Expediente</a></td>';
                                                    echo "</tr>";
                                                }
                                            }
                                        } else {
                                            echo "<td>No hay pacientes por atender</td>";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                <?php endif; ?>

                </div>
            </div>
        </div>

    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>