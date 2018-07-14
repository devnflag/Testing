<?php
    /*include_once("header/header.php");
    include_once("middle/dashboard/dashboard.php");
    include_once("footer/footer.php");*/
    session_start();
    //unset($_SESSION["userID"]);
    if(isset($_SESSION["userID"])){
    //if(1 == 1){
        include_once("header/headerIndex.php");
        include_once("middle/dashboard/dashboard.php");
        include_once("footer/footerIndex.php");
    }else{
        include_once("header/headerLogin.php");
        include_once("middle/login/login.php");
        include_once("footer/footerLogin.php");
    }
?>