<!DOCTYPE html> 
<html> 
<head> 
<meta charset="UTF-8"> 
    <title>Crear Nuevo Usuario</title> 
</head> 
<body> 
 
    <?php         
        //incluir conexión a la base de datos         
        include '../../config/conexionBD.php';                 
 
        $nombres = isset($_POST["nombres"]) ? mb_strtoupper(trim($_POST["nombres"]), 'UTF-8') : null; 
        $apellidos = isset($_POST["apellidos"]) ? mb_strtoupper(trim($_POST["apellidos"]), 'UTF-8') : null;         
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]): null;         
        $contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : null;

        $fotoNombre = $_FILES["foto"]["name"];
        $fotoRuta = $_FILES["foto"]["tmp_name"];
        $fotoDestino = "../../fotos/".$fotoNombre;
        copy($fotoRuta,$fotoDestino);

        $rol = "user";
                
        $sql = "INSERT INTO usuario VALUES (0, '$nombres', '$apellidos', '$correo', MD5('$contrasena'), '$rol', 0, null, null, '$fotoDestino')";         
 
        if ($conn->query($sql) === TRUE) {             
            echo "<p>Se ha creado los datos personales correctamemte!!!</p>";      
        } else {             
            if($conn->errno == 1062){                 
                echo "<p class='error'>La persona con la cedula $cedula ya esta registrada en el sistema </p>";
            }else{                 
                echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>"; 
            }             
        } 
         
        //cerrar la base de datos 
        $conn->close();         echo "<a href='../vista/crear_usuario.html'>Regresar</a>"; 
    ?> 
 
</body> 
</html> 
        