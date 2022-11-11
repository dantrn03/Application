<?php
    session_start();
    @include 'db_conn.php';
    @include 'functions.php';
    @include 'navbar.php';
    echo $_SESSION['user_id'];
    echo $_SESSION['name'];
    echo "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="main_theme.css">
</head>
<body>
    <?php
        getHistories($_SESSION['user_id']);
    ?>
</body>
</html>