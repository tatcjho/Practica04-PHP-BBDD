<?php 
    include '../../config/conexionBD.php';
    session_start();
    if(isset($_SESSION['rol']) != 'user')
        header("Location: ../vista/login.html");
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    $idMen = $_REQUEST['id'];
    $sqlMen = "UPDATE mensaje SET men_eliminado = 1 WHERE men_id = $idMen";
    if ($conn->query($sqlMen) === TRUE) {             
        echo "Eliminado logico Correcto";      
    } else {             
        echo "Error al modificar";
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";           
    }
    $conn->close();
?>