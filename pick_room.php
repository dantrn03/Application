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
        // if ($res) {
        //     while ($row = mysqli_fetch_array($res)) {
        //         $room_no = $row['room_no'];
        //         echo"<p>$room_no</p>";
        //     }
        // }
        echo $_SESSION['name']. "<br>";
        // echo $_SESSION['chosen_hotel_id'];
        // echo $_SESSION['start_date'] . $_SESSION['end_date'];
        $test = $_SESSION['chosen_hotel_id'];
        $chosen_hotel_query = "SELECT * FROM hotels WHERE hotel_id = '$test'";
        $chosen_hotel_res = mysqli_query($conn, $chosen_hotel_query);
        $chosen_hotel_row = mysqli_fetch_array($chosen_hotel_res);
        echo $chosen_hotel_row['hotel_id'] . " " . $chosen_hotel_row['name'];
        $avilable_rooms = getAllRooms($chosen_hotel_row, $_SESSION['start_date'], $_SESSION['end_date']);
        while ($row = mysqli_fetch_array($avilable_rooms)) {
            echo $row['hotel_id'] . " " . $row['room_no'] . " " . $row['price_per_night'] . "<br>";
        }
        // echo "Cc";
    ?>
</body>
</html>

<?php 
    // }
    // else {
    //     echo"ccc";
    // }
?>