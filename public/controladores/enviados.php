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
    <link rel="stylesheet" href="../vista/CSS/gen.css" type="text/css"/>
    <script type="text/javascript" src="../js/ajax.js"></script>
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
    <h1> Identificado como: <?php echo $nombres ?> <?php echo $apellidos ?> </h1>
    <br>
    <h2 class="center"> Bandeja de Salida </h2>

    <input type="text" id="destinatario" class="center" name="destinatario" value="" placeholder="Ingrese el destinatario..." onkeyup="return buscarPorDestinatario()"/> 

    <table class="correo" id="correo"> 

        <colgroup>
            <col style="width: 5%"/>
            <col style="width: 5%"/>
            <col style="width: 5%"/>
            <col style="width: 5%"/>
        </colgroup>

        <thead>
            <tr> 
                <th>Fecha</th>  
                <th>Destinatario</th> 
                <th>Asunto</th>  
                <th></th>           
            </tr> 
        </thead>
 
        <?php
            $sqlMsg = "SELECT * FROM mensaje WHERE usuario_usu_id_de = $id AND men_eliminado = 0 ORDER BY men_fecha DESC"; 
            $resultMsg = $conn->query($sqlMsg);
            if ($resultMsg->num_rows > 0) { 
                 
                while($row = $resultMsg->fetch_assoc()) {    
                    $dest = $row['usuario_usu_id_para'];
                    $sqlDest = "SELECT * FROM usuario WHERE usu_id = $dest";
                    $resultDest = $conn->query($sqlDest);
                    $rowDest = mysqli_fetch_assoc($resultDest);
                    $correoDest = $rowDest['usu_correo'];
                    echo "<tr>";   
                        echo "<td>" . $row['men_fecha'] . "</td>";               
                        echo "<td>" . $correoDest . "</td>";
                        echo "<td>" . $row['men_titulo'] ."</td>"; 
                        echo "<td> <a href='leer.php?id=$row[men_id]'> Leer </a>  </td> ";                                            
                    echo "</tr>";
                }
            } else { 
                echo "<tr>";                 
                echo "<td colspan='4'> Usted no ha enviado mensajes aun </td>";                 
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