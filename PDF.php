<!--Conexion a la base de datos 'medical'-->
<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="icon" href="assets/img/avatars/avatar6.jpeg" sizes="16x16" type="image/png">
</head>
<body>
    <style>
        .contenedor {
            max-width: 120rem;
            width: 80rem;
            margin: 0 auto;
        }
        .contenedorTabla {
            max-width: 100rem;
            width: 70rem;
            margin: 0 auto;
        }
        table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
                    
    </style>
   <?php
    include 'conexion.php';

    // Validación y obtención segura del parámetro 'id'
    $id = null;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // Manejar el caso en el que el parámetro 'id' no es válido
        exit('ID inválido');
    }
        
    // Consulta para obtener información de la visita por ID
    $sql_id = "SELECT * FROM `paciente-visitas` WHERE id_visita= ?";
    $stmt_id = $conn->prepare($sql_id);
    $stmt_id->bind_param("i", $id);
    $stmt_id->execute();
    $result_id = $stmt_id->get_result();

    // Consulta para obtener los doctores asociados con la visita
    $sql_dof = "SELECT id_user FROM `paciente-visitas` WHERE id_visita= ?";
    $stmt_dof = $conn->prepare($sql_dof);
    $stmt_dof->bind_param("i", $id);
    $stmt_dof->execute();
    $stmt_dof->bind_result($doctoress);

    // Recorrer los resultados y procesarlos
    while ($stmt_dof->fetch()) {
        // Aquí puedes hacer algo con $doctoress, como imprimirlo o almacenarlo en una variable para su uso posterior
        // Ejemplo: echo "<script>alert('$doctoress');</script>";
    }
?>


<?php
        include 'conexion.php';
            $user_id = $_SESSION['id'];
            $sql_med = "SELECT firstname,lastname,clinica,imagen,email FROM users WHERE id_user= ?";
            $stmt_med = $conn->prepare($sql_med);
            $stmt_med->bind_param("i", $doctoress);
            $stmt_med->execute();
            $stmt_med->bind_result($names,$last,$clinic,$ima,$ema);
            $stmt_med->fetch();
            $stmt_med->close();

            
        ?>
        <div id="contentToConvert" class="contenedor d-flex flex-column align-items-center justify-content-center mt-5 mb-5" style="border: 1px solid #00000078;">
            <div class="d-flex align-items-left mt-2">
            <?php
                echo '<img src="data:image/jpeg;base64,' . base64_encode($ima) . '" alt="Descripción de la imagen" width="80" height="80">';
            ?>
            </div>
            <div class="d-flex flex-column align-items-center justify-content-center mb-2">
                <?php
                    echo"<h3>"."Clinica ".$clinic."</h3>";
                    echo"<h5>"."Médico ".$names." ".$last."</h5>";
                    echo"<h6>"."Correo: ".$ema." ".$last."</h6>";
                ?>
            </div>

        <div class=" d-flex gap-2 mb-3"  >
            <?php
                include 'conexion.php';
                if ($result_id->num_rows > 0) {
                    // muestra los datos de la bd
                    while ($row = $result_id->fetch_assoc()) {
                        $nam=$row["nombre"];
                        $ape=$row["apellido"];
                        $fec=$row["fecha"];
                            
                            echo "<br>" . 
                            "<strong>Nombre del Paciente:</strong> " . $row["nombre"] . " " . $row["apellido"] . ";<br>" . 
                            "<strong>Cédula:</strong> " . $row["cedula"] . ";<br>" . 
                            "<strong>Fecha de Atención:</strong> " . $row["fecha"].";";
                       
                           
                        
                        }
                    }
               
                $conn->close();
            ?>
      </div>  
      <?php
        include 'conexion.php';
            
            $sql_id2 = "SELECT * FROM `paciente-visitas` WHERE id_visita= ?";
            $stmt_id2 = $conn->prepare($sql_id2);
            $stmt_id2->bind_param("i", $id);
            $stmt_id2->execute();
            $result_id2 = $stmt_id2->get_result();
        ?>
      <div class="contenedorTabla d-flex align-items-center justify-content-center gap-5 mb-3">

            <?php if (isset($result_id2)) :?>
            <table style="margin-bottom:200px">
                <tr>
                    <th>Motivo</th>
                    <th>Síntomas</th> 
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                    
                </tr>
                <?php while ($row = $result_id2->fetch_assoc()) : ?>
                    <tr>
                        
                        <td><?php echo $row["motivo"]; ?></td>
                        <td><?php echo $row["síntomas"]; ?></td>
                        <td><?php echo $row["diagnóstico"]; ?></td>
                        <td><?php echo $row["tratamiento"]; ?></td>
                        
                    </tr>
                <?php endwhile; ?>
                </table>
            <?php endif; ?>

      </div>

      
    </div>
    <div class="contenedor d-flex flex-column align-items-center justify-content-center">
    <button class="btn btn-primary" id="generatePDF">Descargar PDF</button>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const button = document.getElementById("generatePDF");

            button.addEventListener("click", function () {
                const { jsPDF } = window.jspdf;
                const content = document.getElementById("contentToConvert");
                html2canvas(content).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF();
                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save('<?php echo $nam." ".$ape." ".$fec; ?>.pdf');
                });
            });
        });
    </script>
</body>
</html>