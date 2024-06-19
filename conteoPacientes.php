<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'conexion.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID y la clínica del usuario actual
$user_id = $_SESSION['id'];
$sql_clinica = "SELECT clinica FROM users WHERE id_user = ?";
$stmt_clinica = $conn->prepare($sql_clinica);
$stmt_clinica->bind_param("i", $user_id);
$stmt_clinica->execute();
$stmt_clinica->bind_result($clinica);
$stmt_clinica->fetch();
$stmt_clinica->close();

// Consultas SQL para obtener la cantidad de pacientes según el estado y la clínica
$sql_pacientes_por_atender = "SELECT COUNT(*) AS total_pacientes FROM `paciente-visitas` 
    JOIN users ON `paciente-visitas`.id_user = users.id_user
    WHERE `paciente-visitas`.statuss = '0' AND users.clinica = ? AND `paciente-visitas`.fecha = CURDATE()";
$stmt_pacientes_por_atender = $conn->prepare($sql_pacientes_por_atender);
$stmt_pacientes_por_atender->bind_param("s", $clinica);
$stmt_pacientes_por_atender->execute();
$stmt_pacientes_por_atender->bind_result($total_pacientes);
$stmt_pacientes_por_atender->fetch();
$stmt_pacientes_por_atender->close();

$sql_pacientes_atendidos = "SELECT COUNT(*) AS total_pacientes1 FROM `paciente-visitas`
    JOIN users ON `paciente-visitas`.id_user = users.id_user
    WHERE `paciente-visitas`.statuss = '1' AND users.clinica = ? AND `paciente-visitas`.fecha = CURDATE()";
$stmt_pacientes_atendidos = $conn->prepare($sql_pacientes_atendidos);
$stmt_pacientes_atendidos->bind_param("s", $clinica);
$stmt_pacientes_atendidos->execute();
$stmt_pacientes_atendidos->bind_result($total_pacientes1);
$stmt_pacientes_atendidos->fetch();
$stmt_pacientes_atendidos->close();
?>

<div class="row">
    <h3>Fecha: <?php include 'fecha.php'; echo $fecha; ?></h3>
</div>
<!-- Opciones para Médico -->
<?php if ($_SESSION['role'] == 'medico') : ?>
    <div class="d-flex gap-3">
        <div class="col-md-6 col-xl-3 mb-4">
            <a class="col-md-6 col-xl-3 mb-4" href="table.php" style="text-decoration: none;">
                <div class="card shadow border-start-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Pacientes por atender</span></div>
                                <!-- Mostrar la cantidad de pacientes por atender -->
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
                            <!-- Mostrar la cantidad de pacientes atendidos -->
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
                            <!-- Mostrar la cantidad de pacientes sin atender -->
                            <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pacientes . '</span></div>'; ?>
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
                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Consultas Atendidas</span></div>
                            <!-- Mostrar la cantidad de pacientes atendidos -->
                            <?php echo '<div class="text-dark fw-bold h5 mb-0"><span>' . $total_pacientes1 . '</span></div>'; ?>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Fin Opciones para Secretaria -->
<?php endif; ?>
