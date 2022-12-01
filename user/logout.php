<?php

@include 'config.php';

session_start();
session_unset();
session_destroy();
$dir = "../" . "login.php";
echo $dir;

header('location:../login.php');

?>