<?php
    //if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === FALSE ) {
        //header("Location: ../vista/login.html");
        //echo "mal";
    //}
    include '../../config/conexionBD.php';
 
    $usuario = isset($_POST["correo"]) ? trim($_POST["correo"]) : null; 
    $contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : null; 
 
    $sql = "SELECT * FROM usuario WHERE usu_correo = '$usuario' AND usu_password = MD5('$contrasena')"; 
    $sqlA = "SELECT * FROM usuario WHERE usu_correo = '$usuario' AND usu_password = MD5('$contrasena') AND usu_rol = 'admin'";
    $sqlU = "SELECT * FROM usuario WHERE usu_correo = '$usuario' AND usu_password = MD5('$contrasena') AND usu_rol = 'user'";
 
    $result = $conn->query($sql);
    $admin = $conn->query($sqlA);
    $user = $conn->query($sqlU);
    //$result2=$conn->query($sql);
    //while($row2=mysqli_fetch_assoc($result2)){
        //$id=$row2['usu_id'];
    //}
    $resultUsuario=$conn->query($sql);
    $rowUsuario= mysqli_fetch_assoc($resultUsuario);
    $id = $rowUsuario['usu_id'];
    $eliminado = $rowUsuario['usu_eliminado'];
    if ($eliminado == 1) {
        echo "<p>Has sido eliminado por los administradores </p>";
    } else {
        if ($result->num_rows > 0 && $admin->num_rows > 0) { 
            //echo "entro aqui"; 
            session_start();
            $_SESSION['id']=$id;             
            $_SESSION['isLogged'] = TRUE; 
            $_SESSION["rol"] = "admin";     
            header("Location: ../../admin/controladores/index.php"); 
        } else if ($result->num_rows > 0 && $user->num_rows > 0) {
            session_start();
            $_SESSION['id']=$id;             
            $_SESSION['isLogged'] = TRUE;
            $_SESSION["rol"] = "user";    
            header("Location: index.php");
        } else { 
            //header("Location: ../vista/login.html");
            echo "correo o contraseña incorrecta";
        } 
    }
      
    $conn->close();
 
?> 