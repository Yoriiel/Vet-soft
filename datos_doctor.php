

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