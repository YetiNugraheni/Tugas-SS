<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include_once 'character.php';
include_once 'file.php';
$objChar = new Character();
$objFile = new File();

if($_POST['captcha']) {
    if (empty($_POST['user']) or empty($_POST['pass'])){
        $_SESSION['pesan']="Username or password is empty.";            
        header("location:register.php");
    } else {
        if($objChar->CheckLengthCharacter($_POST['captcha'],5) && $_POST['captcha'] == $_SESSION['captchacode']){
            if ($objChar->CheckLengthCharacter($_POST['user'],15) && $objChar->CheckLengthCharacter($_POST['pass'],15)){
                if ($objChar->CheckSpecialCharacter($_POST['user'])){
                    if ($objFile->CheckUser($_POST['user'])){
                        $objFile->InsertUser($_POST['user'], $_POST['pass']);
                    } else {
                        $_SESSION['pesan']="Existing user ".$_POST['user'];
                    }
                    header("location:register.php");
                } else {
                    $_SESSION['pesan']="Don't use special characters in username.";
                    header("location:register.php");
                }
            } else {
                $_SESSION['pesan']="Username or password can not be longer than 15 characters";
                header("location:register.php");
            }
        } else {
            $_SESSION['pesan']="Wrong code.";
            header("location:register.php");
        }
    }
}
else{
    $_SESSION['pesan']="Code is empty.";
    header("location:register.php");
}
?>