        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
       
       <!--menu vertical inicia Actualizado -->
        <nav class="navbar align-items-start sidebar sidebar-dark accordion p-0" style="background: linear-gradient(0deg, #1A661A, #228B22)";>
            <div class="container-fluid d-flex flex-column p-0"><a href="index.php" class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-paw"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Vet-Soft</span></div>
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