<?php 
    include '../../config/conexionBD.php';
    session_start();
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    if($_SESSION["rol"] != "user")
        header("Location: logout.php");
    $sqlUsuario = "SELECT * FROM usuario WHERE usu_id=$id";
    $resultUsuario=$conn->query($sqlUsuario);
    $rowUsuario= mysqli_fetch_assoc($resultUsuario);
    $nombres = $rowUsuario['usu_nombres'];
    $apellidos = $rowUsuario['usu_apellidos'];
    $foto=$rowUsuario['usu_foto_perfil'];
    if (!empty($_POST)) {
        $destinatario = isset($_POST["correo"]) ? trim($_POST["correo"]): null;
        $asunto = isset($_POST["asunto"]) ? trim($_POST["asunto"]): null;
        $mensaje = isset($_POST["mensaje"]) ? trim($_POST["mensaje"]): null;
        $sqlDest = "SELECT * FROM usuario WHERE usu_correo = '$destinatario'";
        $resultDest = $conn->query($sqlDest);
        $rowDest = mysqli_fetch_assoc($resultDest);
        $idDest = $rowDest['usu_id'];
        $sqlMsg = "INSERT INTO mensaje VALUES (0, $id, $idDest, '$asunto', '$mensaje', null, 0 )";
        if ($conn->query($sqlMsg) === TRUE) {             
            echo "<p>Se ha enviado su mensaje correctamente!!!</p>";      
        } else {             
            echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";             
        } 
    }
?>

<!DOCTYPE html> 
<html> 
<head>     
    <meta charset="UTF-8"> 
    <title>Correo: <?php echo $nombres ?> <?php echo $apellidos ?> </title> 
    <link rel="stylesheet" href="../vista/CSS/gen.css" type="text/css"/>
</head> 
<body>

    <table class="menu" style="width:50%">

        <tr> 
            <th><a href="index.php">Inicio</a></th>  
            <th><a href="nuevo.php">Nuevo Mensaje</a></th> 
            <th><a href="enviados.php">Mensajes Enviados</a></th>
            <th><a href="perfil.php">Mi Cuenta</a></th>
            <th><a href="logout.php">Cerrar Sesión</a></th>             
        </tr>

    </table>

    <div class="img">
        <img src="<?php echo $foto ?>">
        <br>
        <span> <?php echo $nombres ?> <?php echo $apellidos ?> </span>
    </div>

    <br>

    <h2 class="center"> Lectura </h2>

    <table class="correo"> 

        <colgroup>
            <col style="width: 5%"/>
            <col style="width: 5%"/>
        </colgroup>

        <?php
            $idMsg = $_REQUEST['id'];
            $sqlMsg = "SELECT * FROM mensaje WHERE men_id = $idMsg"; 
            $resultMsg = $conn->query($sqlMsg);
            $rowMsg = mysqli_fetch_assoc($resultMsg);
            $idRem = $rowMsg['usuario_usu_id_de'];
            $sqlRem = "SELECT * FROM usuario WHERE usu_id = $idRem";
            $resultRem = $conn->query($sqlRem);
            $rowRem = mysqli_fetch_assoc($resultRem);
            $correoRem = $rowRem['usu_correo'];
            $sqlMsg = "SELECT * FROM mensaje WHERE men_id = $idMsg"; 
            $resultMsg = $conn->query($sqlMsg);
            if ($resultMsg->num_rows > 0) { 
                $row = mysqli_fetch_assoc($resultMsg);
                //while($row = $resultMsg->fetch_assoc()) {                      
                    echo "<tr>";
                        echo "<th>Fecha</th>";
                        echo "<td>" . $row['men_fecha'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Remitente</th>";
                        echo "<td>" . $correoRem . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Asunto</th>";
                        echo "<td>" . $row['men_titulo'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Contenido</th>";
                        echo "<td>" . $row['men_contenido'] . "</td>";
                    echo "</tr>";
                //}
            } else { 
                echo "<tr>";                 
                echo "<td colspan='2'> Usted no ha recibito mensajes aun </td>";                 
                echo "</tr>"; 
 
            }
             
            $conn->close();     
        ?> 
    </table>

    
    <br>

    <footer>
        &#8226; &nbsp; Tatiana Domenica Cardenas Jho &nbsp; &#8226; 
        &nbsp; Universidad Politécnica Salesiana &nbsp; &#8226;
        <a href="mailto:tcardenasj@est.ups.edu.ec">tcardenasj@est.ups.edu.ec</a> &nbsp; &#8226;
        <a href="tel:+593998301194">(099) 983-1194</a> &#8226;
        <br>
        &#8226; &nbsp; &#9400; Todos los derechos reservados. &nbsp; &#8226;
    </footer>

 
</body> 
</html> 