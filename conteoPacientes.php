<?php
                    include 'conexion.php';

                    // Consulta SQL para obtener la cantidad de pacientes por atender
                    
                    $user_id = $_SESSION['id'];
                    $sql_pacientes = "SELECT COUNT(*) AS total_pacientes FROM `paciente-visitas` WHERE statuss = '0' AND id_user = $user_id AND fecha = CURDATE()";

                    $stmt_pacientes = $conn->prepare($sql_pacientes);
                    $stmt_pacientes->execute();
                    $stmt_pacientes->bind_result($total_pacientes);
                    $stmt_pacientes->fetch();
                    $stmt_pacientes->close();

                    // Consulta SQL para obtener la cantidad de pacientes que han sido atendidos

                    $sql_pacientes1 = "SELECT COUNT(*) AS total_pacientes1 FROM `paciente-visitas`where statuss='1' AND id_user = $user_id AND fecha = CURDATE()";
                    $stmt_pacientes1 = $conn->prepare($sql_pacientes1);
                    $stmt_pacientes1->execute();
                    $stmt_pacientes1->bind_result($total_pacientes1);
                    $stmt_pacientes1->fetch();
                    $stmt_pacientes1->close();



                    $sql_secre = "SELECT clinica FROM users WHERE id_user= ?";
                    $stmt_secre = $conn->prepare($sql_secre);
                    $stmt_secre ->bind_param("i", $user_id);
                    $stmt_secre ->execute();
                    $stmt_secre ->bind_result($secre);
                    $stmt_secre ->fetch();
                    $stmt_secre ->close();

                    
                    ?>
        <?php
                include 'conexion.php';
            

                // Fixing the first SQL query
                $sql_pa = "SELECT COUNT(*) AS total_pacientes 
                    FROM `paciente-visitas` 
                    JOIN users ON `paciente-visitas`.id_user = users.id_user
                    WHERE `paciente-visitas`.statuss = '0' 
                    AND users.clinica = ? 
                    AND `paciente-visitas`.fecha = CURDATE()";
                $stmt_pa = $conn->prepare($sql_pa);
                $stmt_pa->bind_param("i", $secre);
                $stmt_pa->execute();
                $stmt_pa->bind_result($total_pa);
                $stmt_pa->fetch();
                $stmt_pa->close();

                // Consulta mixta para comparar tablas
                $sql_pa1 = "SELECT COUNT(*) AS total_pacientes 
                FROM `paciente-visitas` 
                JOIN users ON `paciente-visitas`.id_user = users.id_user
                WHERE `paciente-visitas`.statuss = '1' 
                AND users.clinica = ? 
                AND `paciente-visitas`.fecha = CURDATE()";
                $stmt_pa1 = $conn->prepare($sql_pa1);
                $stmt_pa1->bind_param("i", $secre);
                $stmt_pa1->execute();
                $stmt_pa1->bind_result($total_pa1);
                $stmt_pa1->fetch();
                $stmt_pa1->close();
        ?>


                    <div class="row">
                        <h3> Fecha: <?php include 'fecha.php';
                                    echo $fecha; ?> </h3>
                    </div>
                    <!-- Opciones para Médico -->
                    <?php if ($_SESSION['role'] == 'medico') : ?>
                        <div class=" d-flex gap-3 ">
                            <div class="col-md-6 col-xl-3 mb-4">
                            <a class="col-md-6 col-xl-3 mb-4" href="table.php" style="text-decoration: none;">
                                <div class="card shadow border-start-warning py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Pacientes por atender</span></div>
                                                <!-- Mostrar la cantidad de pacientes por atender-->
                                                <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pacientes . '</span></div>'; ?>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                       
                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-warning py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Pacientes Atendidos</span></div>
                                                <!-- Mostrar la cantidad de pacientes por atender-->
                                                <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pacientes1 . '</span></div>'; ?>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Opciones para Médico -->
                        <!-- Opciones para Secretaria -->
                    <?php elseif ($_SESSION['role'] == 'secretaria') : ?>
                        <div class="row">

                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-warning py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Consultas sin Atender</span></div>
                                                <!-- Mostrar la cantidad de pacientes por atender-->
                                                <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pa . '</span></div>'; ?>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-3 mb-4">
                                <div class="card shadow border-start-warning py-2">
                                    <div class="card-body">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col me-2">
                                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Consultas Atendidas </span></div>
                                                <!-- Mostrar la cantidad de pacientes por atender-->
                                                <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pa1 . '</span></div>'; ?>
                                            </div>
                                            <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    <?php endif; ?>
                    <!--Fin  Opciones para Secretaria -->
