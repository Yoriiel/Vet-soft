        <!--menu vertical inicia Actualizado -->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a href="index.php" class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-briefcase-medical"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>MedicalSoft</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fa fa-user-md"></i><span>Inicio</span></a></li>
                <li class="nav-item"><a class="nav-link" href="table.php"><i class="fas fa-user-friends"></i><span>Pacientes por Atender</span></a></li>
                <li class="nav-item"><a class="nav-link" href="consultas.php"<?php echo $_SESSION['role'] !== 'secretaria' ? 'hidden' : ''; ?>><i class="fas fa-table"></i><span>Consulta</span></a></li>
                <li class="nav-item"><a class="nav-link" href="cerrar_sesion.php"><i class="fas fa-external-link-alt"></i><span>Salir</span></a></li>  
                </ul>
                <!--<div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>-->
            </div>
        </nav>
        <!--menu vertical termina el Actualizado-->