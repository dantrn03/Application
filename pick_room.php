<?php
    @include 'navbar.php';
    @include 'db_conn.php';
    @include 'functions.php';
    session_start();
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
        $test = $_SESSION['chosen_hotel_id'];
        $chosen_hotel_query = "SELECT * FROM hotels WHERE hotel_id = '$test'";
        $chosen_hotel_res = mysqli_query($conn, $chosen_hotel_query);
        $chosen_hotel_row = mysqli_fetch_array($chosen_hotel_res);
        echo $chosen_hotel_row ['hotel_id'] . " " . $chosen_hotel_row['name'] . "<br>";
        $avilable_rooms = getAllRooms($chosen_hotel_row, $_SESSION['start_date'], $_SESSION['end_date']);
        echo "<form action=\"confirm_reservation.php\" method=\"post\">";
        while ($row = mysqli_fetch_array($avilable_rooms)) {
            echo $row['hotel_id'] . " " . $row['room_no'] . " " . $row['price_per_night'] . " " . $row['no_of_people'] . "<br>";
            echo $row['room_no']. ": " . "<input type=checkbox name=\"chosen_rooms[]\" value=" . $row['room_no']  . "><br>";
        };
        echo "<input type=\"submit\" value=\"confirm\">";
        echo "</form>";

        $selected_rooms = $_POST['chosen_rooms'];
        print_r($selected_rooms);
    ?>
</body>
</html>