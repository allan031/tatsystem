<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    // //header("refresh:0; url=./welcome.php");
    // if($_SESSION['Platform'] == 'W' || $_SESSION['Platform'] == 'B' || $_SESSION['Platform'] == 'M' ){
    //     header("refresh:0; url=./welcome.php");
    // }
    // else{
    //     header("refresh:0; url=./pages/qr-scan.php");
    // }comment this 2023-09-26
    header("refresh:0; url=./welcome.php");
}else{
    header("refresh:1; url=./login.php");
}


    

    