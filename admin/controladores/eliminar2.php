<?php 
    include '../../config/conexionBD.php';
    session_start();
    if(isset($_SESSION['rol']) != 'user')
        header("Location: ../vista/login.html");
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    $idUs = $_REQUEST['id'];
    $sqlUs = "UPDATE usuario SET usu_eliminado = 1 WHERE usu_id = $idUs";
    if ($conn->query($sqlUs) === TRUE) {             
        echo "Eliminado logico Correcto";      
    } else {             
        echo "Error al eliminar";
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";           
    }
    $conn->close();
?>