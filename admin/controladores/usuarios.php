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
    <link rel="stylesheet" href="../../public/vista/styles/style.css" type="text/css"/>
</head> 
<body>
    
    <table class="menu"> 

        <tr> 
            <th><a href="index.php">Inicio</a></th>  
            <th><a href="usuarios.php">Usuarios</a></th>
            <th><a href="../../public/controladores/logout.php">Cerrar Sesión</a></th>             
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
    <h2 class="center"> Usuarios </h2>

    <table  id='correo'> 

        <colgroup>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
            <col style='width: 5%'>
        </colgroup>

        <thead>
            <tr>
                <th>Foto Perfil</th>
                <th>Nombres</th>  
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Fecha Creacion</th>
                <th>Ultima Modificacion</th>
                <th>Eliminado</th>
                <th></th>
                <th></th>          
            </tr>
        </thead>
 
        <?php  
            
            $sqlUsuario = "SELECT * FROM usuario WHERE usu_rol='user'";
            $resultUsuario=$conn->query($sqlUsuario);
            if ($resultUsuario->num_rows > 0) { 
                $sqlUsuario = "SELECT * FROM usuario WHERE usu_rol='user'";
                $resultUsuario=$conn->query($sqlUsuario);
                $row = mysqli_fetch_assoc($resultUsuario);
               
                while($row = $resultUsuario->fetch_assoc()) {  
                    echo "<tr>"; 
                        echo "<td>"."<img src='".$row['usu_foto_perfil']."'>"."</td>";  
                        echo "<td>" . $row['usu_nombres'] . "</td>";               
                        echo "<td>" . $row['usu_apellidos'] . "</td>";
                        echo "<td>" . $row['usu_correo'] . "</td>";
                        echo "<td>" . $row['usu_fecha_creacion'] ."</td>";
                        echo "<td>" . $row['usu_fecha_modificacion'] ."</td>";
                        echo "<td>" . $row['usu_eliminado'] ."</td>";
                        if ($row['usu_eliminado'] == 0) {                             
                            echo "<td> <a href='eliminar2.php?id=$row[usu_id]'> Eliminar </a>  </td> ";                                                                  
                        } else {
                            echo "<td>  </td> ";
                        }
                        echo "<td> <a href='modificar.php?id=$row[usu_id]'> Modificar </a>  </td> ";
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