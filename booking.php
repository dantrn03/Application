<?php
    session_start();
    @ include 'navbar.php';
    @ include 'db_conn.php';
    @ include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" type="text/css" href="main_theme.css">
    
</head>
<body>
    <h1>Booking!</h1>
    <form method="post">
        <div><label>
            Location
        </label> 
        <?php 
        createLocationSelection(); 
        echo "</div><br><div><label>Service </label> ";
        createServiceSelection();
        echo "</div>";
        ?>
        <br>
        <div>
        <label for="start_date" required>From</label>
        <input class="condition" type="date" id="start_date" name="start_date" required>
        </div>
        <br>
        <div>
        <label for="start_date">To</label>
        <input class="condition" type="date" id="start_date" name="end_date" required>
        </div> <br>
        <input type="submit" name="condition" value="Browse">
    </form>

    <?php 
        if (isset($_POST['condition'])) {
            $selected_city_condition = mysqli_escape_string($conn,$_POST['city']);
            $selected_service_condition = mysqli_escape_string($conn, $_POST['service']);
            // echo "Hiii" . $selected_city_condition. " " . $selected_service_condition . "<br>";
            // $selected_city = ($selected_city_condition == 0) ? "" : " WHERE location = '$selected_city_condition'";
            $condition = "";
            if ($selected_city_condition != 0 && $selected_service_condition != 0) {
                $condition = " WHERE location = '$selected_city_condition' AND service_id = '$selected_service_condition'";
            } else if ($selected_city_condition != 0) {
                $condition = " WHERE location = '$selected_city_condition'";
            } else if ($selected_service_condition != 0) {
                $condition = " WHERE service_id = '$selected_service_condition'";
            } 
            // echo $selected_city;
            $select_hotel_query = "SELECT * FROM hotels" . $condition;
            $hotels = mysqli_query($conn, $select_hotel_query);
            $_SESSION['start_date'] = $_POST['start_date'];
            $_SESSION['end_date'] = $_POST['end_date'];
            createHotels($hotels, $_SESSION['start_date'], $_SESSION['end_date']);
        }
        if(isset($_POST['book_hotel'])){
            $_SESSION['chosen_hotel_id'] =  $_POST['chosen_hotel_id'];
            header('location:pick_room.php');
        }
    ?>
</body>
</html>