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
        $rolDest = $rowDest['usu_rol'];
        $eliminadoDest = $rowDest['usu_eliminado'];
        $sqlMsg = "INSERT INTO mensaje VALUES (0, '$asunto', '$mensaje', SYSDATE(), 0, $id, $idDest)";
        if($rolDest == 'admin'){
            echo "<p>El usuario con correo $destinatario es un administrador </p>"; 
        } else if ($eliminadoDest == 1) {
        
            echo "<p>El usuario con correo $destinatario ha sido eliminado por los administradores </p>";
        } else {     
            $conn->query($sqlMsg) === TRUE;        
            echo "<p>Se ha enviado su mensaje correctamente!!!</p>";      
        } 
        if (mysqli_error($conn)) {             
            echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";             
        } 
    }
?>

<!DOCTYPE html> 
<html> 
<head>     
    <meta charset="UTF-8"> 
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

    <br>
    <h1> Identificado como: <?php echo $nombres ?> <?php echo $apellidos ?> </h1>
    <br>

    <h1 class="center" > Nuevo Mensaje </h1>
    <br>

    <form id="formulario01" class="center" method="POST" onsubmit="" action=""> 

            <label for="destinatario">Para: </label> 
            <input type="email" id="correo" name="correo" value="" placeholder="Ingrese el correo del destinatario..."/> 
            <br> 

            <label for="asunto">Asunto: </label> 
            <input type="text" id="asunto" name="asunto" value="" placeholder="Ingrese el asunto..."/> 
            <br> 
             
            <label for="mensaje">Mensaje:</label> <br>
            <input type="text" id="mensaje" class="mensaje" name="mensaje" value="" placeholder="Escriba su mensaje..."/> 
            <br> 
             
            <input type="submit" id="enviar" name="enviar" value="Enviar" /> 
            <input type="reset" id="cancelar" name="cancelar" value="Cancelar" />
                     
    </form>
    
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