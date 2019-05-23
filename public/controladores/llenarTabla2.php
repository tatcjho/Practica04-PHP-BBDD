<?php
    include '../../config/conexionBD.php';
    session_start();
    if (isset($_SESSION['id']))
        $id=$_SESSION['id'];
    if($_SESSION["rol"] != "user")
        header("Location: logout.php");
        echo "<colgroup>";
            echo "<col style='width: 5%'/>";
            echo "<col style='width: 5%'/>";
            echo "<col style='width: 5%'/>";
            echo "<col style='width: 5%'/>";
        echo "</colgroup>";
        echo "<thead>";
            echo "<tr>";
                echo "<th>Fecha</th>";  
                echo "<th>Destinatario</th>"; 
                echo "<th>Asunto</th>"; 
                echo "<th></th>";          
            echo "</tr>";
        echo "</thead>";
        $sqlMsg = "SELECT * FROM mensaje WHERE usuario_usu_id_de = $id AND men_eliminado = 0 ORDER BY men_fecha DESC"; 
        $resultMsg = $conn->query($sqlMsg);
   
        while($row = $resultMsg->fetch_assoc()) {  
            
            $dest = $row['usuario_usu_id_para'];
            $sqlDest = "SELECT * FROM usuario WHERE usu_id = $dest";
            $resultDest = $conn->query($sqlDest);
            $rowDest = mysqli_fetch_assoc($resultDest);
            $correoDest = $rowDest['usu_correo'];
            echo "<tr id='bandeja'>";   
                echo "<td>" . $row['men_fecha'] . "</td>";        
                echo "<td>" . $correoDest . "</td>";
                echo "<td>" . $row['men_titulo'] ."</td>";
                echo "<td> <a href='leer.php?id=$row[men_id]'> Leer </a>  </td> ";                                           
            echo "</tr>";
            
        }
    $conn->close();
?>