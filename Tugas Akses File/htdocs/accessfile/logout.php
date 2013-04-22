<?php
session_start();
session_destroy();
include_once 'file.php';
$ObjFile = new File();
$ObjFile->DeleteSession();

header("location:index.php");
?>
