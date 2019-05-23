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
    if (!empty($_POST)) {
        if (empty($_POST['idusuario'])) {
            header("location: index.php");
        }
        $contrasenaAnterior = isset($_POST["contrasenaAnterior"]) ? trim($_POST["contrasenaAnterior"]) : null;
        $contrasenaNueva = isset($_POST["contrasenaNueva"]) ? trim($_POST["contrasenaNueva"]) : null;
        $sql = "SELECT * FROM usuario WHERE usu_id = $id AND usu_password = MD5('$contrasenaAnterior')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sql2 = "UPDATE usuario SET usu_password = MD5('$contrasenaNueva'),
                                        usu_fecha_modificacion = SYSDATE()
                                WHERE usu_id = $id";
            if ($conn->query($sql2) === TRUE) {             
                echo "Modificado Correctamente";                  
            } else {             
                echo "Error al modificar";
                echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";           
            }
            $conn->close();
        }
        
    }
?>

<!DOCTYPE html> 
<html> 
<head> 
    <meta charset="UTF-8">
    <script type="text/javascript" src="../js/validacion.js"></script>
    <title>Correo: <?php echo $nombres ?> <?php echo $apellidos ?> </title> 
    <link rel="stylesheet" href="../vista/styles/style.css" type="text/css"/>  
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

    <section>

        <h2 class="center"> Cambiar Contraseña: </h2>
        <br>

        <div class="center">
            <form id="formulario01" method="POST" onsubmit="return validarCamposObligatorios()" action=""> 
 
                <label for="contrasenaAnterior">Contraseña Anterior:</label> 
                <input type="password" id="contrasenaAnterior" name="contrasenaAnterior" value="" placeholder="Ingrese su contrasena anterior..."> 
                <br> 
 
                <label for="contrasenaNueva">Contraseña Nueva:</label> 
                <input type="password" id="contrasenaNueva" name="contrasenaNueva" value="" placeholder="Ingrese su contrasena nueva..." > 
                <br>             

 
                <input type="hidden" name="idusuario" value="<?php echo $id; ?>">
                <input type="submit" value="Cambiar" >

        </form>     
        </div>


        <div>
            
            
        </div>

    </section>

 
</body> 
</html> 