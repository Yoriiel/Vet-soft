

<?php

//Aqui se seleccionan los datos del doctor ,para hacerlo visible en todas las vistas
                                include 'conexion.php';

                                // Suponiendo que tengas el ID del usuario almacenado en alguna variable
                                $user_id = $_SESSION['id']; // Por ejemplo, supongamos que almacenaste el ID del usuario en una variable de sesión

                                // Consulta SQL para obtener el nombre completo del usuario
                                $sql = "SELECT firstname, lastname,imagen,email FROM users WHERE id_user = ?"; // Ajusta la consulta según la estructura de tu base de datos
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $stmt->bind_result($firstName, $lastName,$imagenp,$eMail);
                                $stmt->fetch();

                                // Concatenar el nombre completo
                                $fullName = $firstName . " " . $lastName;

                                // Cerrar la conexión y liberar recursos
                                $stmt->close();
                                $conn->close();
?>
<li class="nav-item dropdown no-arrow">
    <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $fullName;?></span><img class="border rounded-circle img-profile" src="data:image/webp;base64,<?php echo base64_encode($imagenp); ?>"></a>
        <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
            <a class="dropdown-item" href="index.php"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Perfil</a>
            <a class="dropdown-item" href="profile.php"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Configuración</a>
            <div class="dropdown-divider"></div><a class="dropdown-item" href="cerrar_sesion.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Cerrrar Sesión</a>
        </div>
    </div>
</li>