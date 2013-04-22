<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include_once 'character.php';
include_once 'file.php';
$objChar = new Character();
$objFile = new File();
if (!$objFile->CheckSession()){
    header("location:index.php");
}

if (empty($_POST['filename']) || !$objFile->CheckValidFile($_POST['filename'])){
    header("location:list_files.php");
} else {
    $objFile->ResetSession();
}

if($_POST['captcha']) {
    if (empty($_POST['filename'])){
        $_SESSION['pesan']="Filename is empty.";            
        header("location:list_files.php");
    } else {
        if($objChar->CheckLengthCharacter($_POST['captcha'],5) && $_POST['captcha'] == $_SESSION['captchacode']){
            if ($objChar->CheckLengthCharacter($_POST['filename'],15)){
                if ($objChar->CheckSpecialCharacter($_POST['filename'])){
                    if ($objChar->CheckWhitespace($_POST['filename'])){ 
                        $_POST['filename']=trim($_POST['filename']);
                        if ($objFile->CheckFile($_POST['filename'])){
                            $objFile->CreateFile($_POST['filename']);
                        } else {
                            $_SESSION['pesan']="Existing file ".$_POST['user'];
                        }
                        header("location:list_files.php");
                    } else {
                        $_SESSION['pesan']="Don't use special characters or whitespace in filename.";
                        header("location:list_files.php");
                    }
                } else {
                    $_SESSION['pesan']="Don't use special characters or whitespace in filename.";
                    header("location:list_files.php");
                }
            } else {
                $_SESSION['pesan']="Filename can not be longer than 15 characters";
                header("location:list_files.php");
            }
        } else {
            $_SESSION['pesan']="Wrong code.";
            header("location:list_files.php");
        }
    }
}
else{
    $_SESSION['pesan']="Code is empty.";
    header("location:list_files.php");
}

$objFile->ResetSession();
?>
