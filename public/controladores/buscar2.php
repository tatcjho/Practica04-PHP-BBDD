<?php
    include '../../config/conexionBD.php';
    session_start();
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    if($_SESSION["rol"] != "user")
        header("Location: logout.php");
    $dest = $_GET['destinatario'];
 
        $sqlDest = "SELECT * FROM usuario WHERE usu_correo LIKE '%$dest%'";
        $resultDest = $conn->query($sqlDest);
        $rowDest = mysqli_fetch_assoc($resultDest);
        $idDest = $rowDest['usu_id'];
        $correoDest = $rowDest['usu_correo'];
        echo "<colgroup>";
            echo "<col style='width: 5%'/>";
            echo "<col style='width: 5%'/>";
            echo "<col style='width: 5%'/>";
            echo "<col style='width: 5%'/>";
        echo "</colgroup>";
        echo "<thead>";
            echo "<tr>";
                echo "<th>Fecha</th>";  
                echo "<th>Remitente</th>"; 
                echo "<th>Asunto</th>"; 
                echo "<th></th>";          
            echo "</tr>";
        echo "</thead>";
        $sqlMsg = "SELECT * FROM mensaje WHERE usuario_usu_id_de = $id AND usuario_usu_id_para = $idDest AND men_eliminado = 0  ORDER BY men_fecha DESC"; 
        $resultMsg = $conn->query($sqlMsg);
   
        while($row = $resultMsg->fetch_assoc()) {   
            echo "<tr id='bandeja'>";   
                echo "<td>" . $row['men_fecha'] . "</td>";        
                echo "<td>" . $correoDest . "</td>";
                echo "<td>" . $row['men_titulo'] ."</td>";
                echo "<td> <a href='leer.php?id=$row[men_id]'> Leer </a>  </td> ";                                           
            echo "</tr>";
        }
        
    
    $conn->close();
?>