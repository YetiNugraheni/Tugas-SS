<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include_once 'file.php';
$ObjFile = new File();
if (!$ObjFile->CheckSession()){
    header("location:index.php");
}

if (empty($_GET['id']) || !$ObjFile->CheckValidFile($_GET['id'])){
    header("location:list_files.php");
} else {
    $ObjFile->DeleteFile($_GET['id']);
    header("location:list_files.php");
}

?>
