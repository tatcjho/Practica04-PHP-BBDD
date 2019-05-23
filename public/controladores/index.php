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
    $nombres=$rowUsuario['usu_nombres'];
    $apellidos=$rowUsuario['usu_apellidos'];
    $foto=$rowUsuario['usu_foto_perfil'];
?>

<!DOCTYPE html> 
<html> 
<head>     
    <meta charset="UTF-8"> 
    <title>Correo: <?php echo $nombres ?> <?php echo $apellidos ?> </title> 
    <link rel="stylesheet" href="../vista/styles/style.css" type="text/css"/>
    <script type="text/javascript" src="../js/ajax.js"></script>
</head> 
<body>
    
    <table class="menu"> 

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

    <h1> Identificado como: <?php echo $nombres ?> <?php echo $apellidos ?> </h1>
    <br>
    <h2 class="center"> Bandeja de Entrada </h2>

    <input type="text" id="remitente" class="center" name="remitente" value="" placeholder="Ingrese el remitente..." onkeyup="return buscarPorRemitente()"/> 

    <table class="correo" id='correo'> 

        <colgroup>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
        </colgroup>

        <thead>
            <tr>
                <th>Fecha</th>  
                <th>Remitente</th>
                <th>Asunto</th> 
                <th></th>          
            </tr>
        </thead>
 
        <?php  
            
            $sqlMsg = "SELECT * FROM mensaje WHERE usuario_usu_id_para = $id ORDER BY men_fecha DESC"; 
            $resultMsg = $conn->query($sqlMsg);
            if ($resultMsg->num_rows > 0) { 
                $sqlMsg = "SELECT * FROM mensaje WHERE usuario_usu_id_para = $id AND men_eliminado = 0 ORDER BY men_fecha DESC"; 
                $resultMsg = $conn->query($sqlMsg);
                
                while($row = $resultMsg->fetch_assoc()) {  
                    
                    $rem = $row['usuario_usu_id_de'];
                    $sqlRem = "SELECT * FROM usuario WHERE usu_id = $rem";
                    $resultRem = $conn->query($sqlRem);
                    $rowRem = mysqli_fetch_assoc($resultRem);
                    $correoRem = $rowRem['usu_correo']; 
                    echo "<tr id='bandeja'>";   
                        echo "<td>" . $row['men_fecha'] . "</td>";               
                        echo "<td>" . $correoRem . "</td>";
                        echo "<td>" . $row['men_titulo'] ."</td>"; 
                        echo "<td> <a href='leer.php?id=$row[men_id]'> Leer </a>  </td> ";                                            
                    echo "</tr>";
                }
            } else { 
                echo "<tr>";                 
                echo "<td colspan='4'> No hay resultados de la busqueda </td>";                 
                echo "</tr>"; 
 
            }
            $conn->close();
        ?>
        
    </table>

    <br>

    <footer>
        &#8226; &nbsp; Pedro Jose Ortiz Solis &nbsp; &#8226; 
        &nbsp; Universidad Politécnica Salesiana &nbsp; &#8226;
        <a href="mailto:portizs2@est.ups.edu.ec">portizs2@est.ups.edu.ec</a> &nbsp; &#8226;
        <a href="tel:+593991936486">(099) 193-6486</a> &#8226;
        <br>
        &#8226; &nbsp; &#9400; Todos los derechos reservados. &nbsp; &#8226;
    </footer>

</body> 
</html> 