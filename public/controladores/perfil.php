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
    $foto=$rowUsuario['usu_foto_perfil'];
    $nombres=$rowUsuario['usu_nombres'];
    $apellidos=$rowUsuario['usu_apellidos'];
    $correo=$rowUsuario['usu_correo'];
    $rol=$rowUsuario['usu_rol'];
    $fecha_creacion=$rowUsuario['usu_fecha_creacion'];
    $fecha_modificacion=$rowUsuario['usu_fecha_modificacion'];
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
    
    <br>
    <h1 class="center" > Informacion del usuario: <br> <?php echo $nombres ?> <?php echo $apellidos ?> </h1>
    <br>

    
    <table class="correo"> 

        <colgroup>
            <col style="width: 5%"/>
            <col style="width: 5%"/>
        </colgroup>

        <?php
            $resultUsuario=$conn->query($sqlUsuario);
            
            if ($resultUsuario->num_rows > 0) {
                $row = mysqli_fetch_assoc($resultUsuario);
                //while($row = $resultMsg->fetch_assoc()) {                      
                    echo "<tr>";
                        echo "<th>Foto de Perfil: </th>";
                        echo "<td>" . "<img src= $foto >" . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Correo</th>";
                        echo "<td id='dato'>" . $correo . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Rol</th>";
                        echo "<td id='dato'>" . $rol . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Fecha de Creacion</th>";
                        echo "<td id='dato'>" . $fecha_creacion . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th>Fecha de Ultima Modificacion</th>";
                        echo "<td id='dato'>" . $fecha_modificacion. "</td>";
                    echo "</tr>";
                    echo "<tr>";                 
                        echo "<td class='modificar'> <a href='modificar.php'> Modificar </a> </td>";  
                        echo "<td class='modificar'> <a href='contrasena.php'> Cambiar Contrasena </a> </td>";               
                    echo "</tr>"; 
                //}
            } else { 
                echo "<tr>";                 
                echo "<td colspan='2'> Error </td>";                 
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