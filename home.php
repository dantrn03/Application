<?php
    include 'navbar.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="main_theme.css">
</head>
<body>
    <h1>Make My Stay</h1>
    <h2> Hi, <?php
    echo $_SESSION['name'];
    ?>
    </h2>
    <p>It's our pleasure to make your day :></p>
</body>
</html>