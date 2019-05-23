<?php
    session_start(); 
    unset($_SESSION['isLogged']);
    unset($_SESSION['id']);
    unset($_SESSION['rol']);
    unset($_SESSION);
    session_destroy();
    header("Location: ../vista/login.html");
?>