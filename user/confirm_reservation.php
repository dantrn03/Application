<?php
    session_start();
    @include 'db_conn.php';
    @include 'navbar.php';
    @include 'functions.php';
    // echo "Hello world";
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
    // echo $_POST['chosen_rooms'];
    // echo "<br>";
    // echo $_SESSION['user_id'];
    // echo "<br>";
    // echo $_SESSION['start_date']. "<br>" . $_SESSION['end_date'] . "<br>";
    // echo $_SESSION['chosen_hotel_id'];
    $insert_reservation_query = "INSERT INTO reservations (user_id, date_from, date_to) VALUES (" . $_SESSION['user_id'] . ",'" . $_SESSION['start_date'] . "','"  . $_SESSION['end_date'] . "')";
    if (mysqli_query($conn, $insert_reservation_query)) {
        $last_id = mysqli_insert_id($conn);
        
        // echo "<br>New inserted id: ". $last_id;
    
        foreach($_POST['chosen_rooms'] as $value) {
            $insert_details_query = "INSERT INTO details (reservation_id, hotel_id, room_no) VALUES (" . $last_id . "," . $_SESSION['chosen_hotel_id'] . "," . $value . ")" ;
            mysqli_query($conn, $insert_details_query);
            // echo $value . "<br>";
        }
    }
    else {
        echo "fail";
    }
    ?>
    <p>Your reservation is success <br>
    Watch your reservations at <a href="history.php">History</a></p>
</body>
</html>