<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include_once 'file.php';
$objFile = new File();

if($_POST['captcha']) {
    if($_POST['captcha'] == $_SESSION['captchacode']){
        if (empty($_POST['user']) or empty($_POST['pass'])){
            $_SESSION['pesan']="Username or password is empty.";            
            header("location:index.php");
        } else {
            if ($objFile->CheckValidUser($_POST['user'], $_POST['pass'])) {
                $objFile->SetSession($_POST['user']);
                header("location:list_files.php");
            } else {
                $_SESSION['pesan']="Username or password is wrong.";
                header("location:index.php");
            }
        }
    }
    else{
        header("location:index.php");
        $_SESSION['pesan']="Wrong code.";
    }
}
else{
    header("location:index.php");
    $_SESSION['pesan']="Code is empty.";
}
?>