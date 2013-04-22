<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

include_once 'file.php';
$ObjFile = new File();
if (!$ObjFile->CheckSession()){
    header("location:index.php");
}

$ObjFile->CheckValidFile($_POST['filename']);
if (empty($_POST['filename']) || !$ObjFile->CheckValidFile($_POST['filename'])){
    header("location:list_files.php");
} else {
    $ObjFile->SaveFile($_POST['filecontent'], $_POST['filename']);
    header("location:list_files.php");
}

?>
