<?php
    session_start();
    if(isset($_SESSION["userID"])){
        include_once("header/headerIndex.php");
        include_once("middle/dashboard/dashboard.php");
        include_once("footer/footerIndex.php");
    }else{
        include_once("header/headerLogin.php");
        include_once("middle/login/login.php");
        include_once("footer/footerLogin.php");
    }
?>