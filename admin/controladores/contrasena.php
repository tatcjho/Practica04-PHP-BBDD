<?php
        
    include '../../config/conexionBD.php';
    session_start();
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    if($_SESSION["rol"] != "admin")
        header("Location: logout.php");
    $idUsuario = $_REQUEST['id'];
    $sqlAdmin = "SELECT * FROM usuario WHERE usu_id = $id";
    $resultAdmin=$conn->query($sqlAdmin);
    $rowAdmin= mysqli_fetch_assoc($resultAdmin);
    $nombresAdmin=$rowAdmin['usu_nombres'];
    $apellidosAdmin=$rowAdmin['usu_apellidos'];
    $fotoAdmin=$rowAdmin['usu_foto_perfil'];
    $sqlUsuario = "SELECT * FROM usuario WHERE usu_id=$idUsuario";
    $resultUsuario=$conn->query($sqlUsuario);
    $rowUsuario= mysqli_fetch_assoc($resultUsuario);
    
    $nombres=$rowUsuario['usu_nombres'];
    $apellidos=$rowUsuario['usu_apellidos'];
    $foto=$rowUsuario['usu_foto_perfil'];
    $correo=$rowUsuario['usu_correo'];
    $eliminado=$rowUsuario['usu_eliminado'];
    $rol=$rowUsuario['usu_rol'];
    if (!empty($_POST)) {
        if (empty($_POST['idusuario'])) {
            header("location: index.php");
        }
        $nContrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]): null;
            
        $sql2 = "UPDATE usuario SET usu_password = MD5('$nContrasena') WHERE usu_id = $idUsuario";
    
        if ($conn->query($sql2) === TRUE) {             
            echo "Modificado Correctamente";                  
        } else {             
            echo "Error al modificar";
            echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";           
        }
        $conn->close();
        
    }
?>

<!DOCTYPE html> 
<html> 
<head> 
    <meta charset="UTF-8">
    <script type="text/javascript" src="../js/validacion.js"></script>
    <title>Correo: <?php echo $nombres ?> <?php echo $apellidos ?> </title> 
    <link rel="stylesheet" href="../../public/vista/CSS/gen.css" type="text/css"/>  
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
        <img src="<?php echo $fotoAdmin ?>">
        <br>
        <span> <?php echo $nombresAdmin ?> <?php echo $apellidosAdmin ?> </span>
    </div>

    <section>

        <h2 class="center"> Modificar: </h2>

        <div class="center">
            <form id="formulario01" method="POST" action=""> 

                <img id="fusu" src="<?php echo $foto ?>">
                <br>
                <br>

                <label for="contrasena">Nueva Contraseña:</label> 
                <input type="password" id="contrasena" name="contrasena" value="" placeholder="Ingrese sus dos nombres ..."> 
                <br>
 
                <input type="hidden" name="idusuario" value="<?php echo $id; ?>">
                <input type="submit" value="Modificar" >

        </form>     
        </div>


        <div>
            
            
        </div>

    </section>
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