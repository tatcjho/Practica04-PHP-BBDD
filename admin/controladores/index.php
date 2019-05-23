<?php 
    include '../../config/conexionBD.php';
    session_start();
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    if($_SESSION["rol"] != "admin")
        header("Location: ../../public/controladores/logout.php");
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
    <link rel="stylesheet" href="../../public/vista/CSS/general.css" type="text/css"/>  

</head> 
<body>
    
    <table class="menu"> 

        <tr> 
            <th><a href="index.php">Inicio</a></th>  
            <th><a href="usuarios.php">Usuarios</a></th>
            <link rel="stylesheet" href="../../public/vista/CSS/gen.css" type="text/css"/>  
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
    <h2 class="center"> Mensajes </h2>

    <table class="correo" id='correo'> 

        <colgroup>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
        </colgroup>

        <thead>
            <tr>
                <th>Fecha</th>  
                <th>Remitente</th>
                <th>Destinatario</th>
                <th>Asunto</th>
                <th>Eliminado</th>
                <th></th>          
            </tr>
        </thead>
 
        <?php  
            
            $sqlMsg = "SELECT * FROM mensaje ORDER BY men_fecha DESC"; 
            $resultMsg = $conn->query($sqlMsg);
            if ($resultMsg->num_rows > 0) { 
                $sqlMsg = "SELECT * FROM mensaje ORDER BY men_fecha DESC"; 
                $resultMsg = $conn->query($sqlMsg);
               
                while($row = $resultMsg->fetch_assoc()) {  
                    
                    
                    $rem = $row['usuario_usu_id_de'];
                    $sqlRem = "SELECT * FROM usuario WHERE usu_id = $rem";
                    $resultRem = $conn->query($sqlRem);
                    $rowRem = mysqli_fetch_assoc($resultRem);
                    $correoRem = $rowRem['usu_correo'];
                    
                    $dest = $row['usuario_usu_id_para'];
                    $sqlDest = "SELECT * FROM usuario WHERE usu_id = $dest";
                    $resultDest = $conn->query($sqlDest);
                    $rowDest = mysqli_fetch_assoc($resultDest);
                    $correoDest = $rowDest['usu_correo'];

                    
                    echo "<tr id='bandeja'>";   
                        echo "<td>" . $row['men_fecha'] . "</td>";               
                        echo "<td>" . $correoRem . "</td>";
                        echo "<td>" . $correoDest . "</td>";
                        echo "<td>" . $row['men_titulo'] ."</td>";
                        echo "<td>" . $row['men_eliminado'] ."</td>";
                        if ($row['men_eliminado'] == 0) {                             
                            echo "<td> <a href='eliminar.php?id=$row[men_id]'> Eliminar </a>  </td> ";                                                                  
                        }
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
        &#8226; &nbsp; Tatiana Domenica Cardenas Jho &nbsp; &#8226; 
        &nbsp; Universidad Politécnica Salesiana &nbsp; &#8226;
        <a href="mailto:tcardenasj@est.ups.edu.ec">tcardenasj@est.ups.edu.ec</a> &nbsp; &#8226;
        <a href="tel:+593998301194">(099) 983-1194</a> &#8226;
        <br>
        &#8226; &nbsp; &#9400; Todos los derechos reservados. &nbsp; &#8226;
    </footer>
</body> 
</html> 