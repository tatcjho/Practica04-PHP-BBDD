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
        $nNombres = isset($_POST["nombres"]) ? mb_strtoupper(trim($_POST["nombres"]), 'UTF-8') : null; 
        $nApellidos = isset($_POST["apellidos"]) ? mb_strtoupper(trim($_POST["apellidos"]), 'UTF-8') : null;        
        $nCorreo = isset($_POST["correo"]) ? trim($_POST["correo"]): null;
        //$nContrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]): null;
        $nRol = isset($_POST["rol"]) ? trim($_POST["rol"]): null;
        $nEliminado = isset($_POST["eliminado"]) ? trim($_POST["eliminado"]): null;
            
        $sql2 = "UPDATE usuario SET usu_nombres = '$nNombres',
                                    usu_apellidos = '$nApellidos', 
                                    usu_correo = '$nCorreo';                                
                                    usu_rol = '$nRol',
                                    usu_eliminado = '$nEliminado',
                                    usu_fecha_modificacion = SYSDATE()
                                WHERE usu_id = $idUsuario";
    
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
        <img src="<?php echo $fotoAdmin ?>">
        <br>
        <span> <?php echo $nombresAdmin ?> <?php echo $apellidosAdmin ?> </span>
    </div>

    <section>

        <h2 class="center"> Modificar: </h2>

        <div class="center">
            <form id="formulario01" method="POST" onsubmit="return validarCamposObligatorios()" action=""> 

                <img id="fusu" src="<?php echo $foto ?>">
                <br>
                <br>

                <label for="nombres">Nombres:</label> 
                <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>" placeholder="Ingrese sus dos nombres ..."> 
                <br> 
 
                <label for="apellidos">Apelidos:</label> 
                <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" placeholder="Ingrese sus dos apellidos..." > 
                <br>             
 
                <label for="correo">Correo electrónico:</label> 
                <input type="email" id="correo" name="correo" value="<?php echo $correo; ?>" placeholder="Ingrese su correo electrónico ..."> 
                <br>

                <label for="rol">rol:</label> 
                <input type="text" id="rol" name="rol" value="<?php echo $rol; ?>" placeholder="user o admin..."> 
                <br>

                <label for="eliminado">Eliminado:</label> 
                <input type="number" id="eliminado" name="eliminado" value="<?php echo $eliminado; ?>" placeholder="0 o 1..."> 
                <br>
 
                <input type="hidden" name="idusuario" value="<?php echo $id; ?>">
                <input type="submit" value="Modificar" >
                <a href="contrasena.php?id=<?php echo $idUsuario ?>"> Cambiar Contraseña </a>

        </form>     
        </div>


        <div>
            
            
        </div>

    </section>

 
</body> 
</html> 