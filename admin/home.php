<?php
    session_start();
    @ include 'navbar.php';
    @ include '../db_conn.php';
    // @ include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="main_theme.css">
</head>
<body>
    hi admin <?php echo $_SESSION['name']; ?>
</body>
</html>