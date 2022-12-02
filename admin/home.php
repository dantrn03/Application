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
    <h1> Hello admin <?php echo $_SESSION['name']; ?> </h1>
    <h3> What do you want to modify today?</h3>
        <div class="adminhome"><a href = "hotel.php">Hotel</a></div>
        <div class="adminhome"><a href = "service.php">Service</a></div>
        <div class="adminhome"><a href="provide.php">Provide</a></div>
        <div class="adminhome"><a href="rooms.php">Rooms</a></div>
</body>
</html>