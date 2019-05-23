<?php
    //session_start();
    //if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === FALSE){
    //    header("location: ../public/vista/login.html");
    //}
    //session_start();
    if(isset($_SESSION['rol']) != 'user'){
        header("Location: ../vista/login.html");
	}
?>