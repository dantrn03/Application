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
        <label>
            Country
        </label> 
        <select class = "country_selection" id="country_selection" name="city">
            <?php 
                $country_query = "SELECT DISTINCT location FROM hotels";
                $countries = mysqli_query($conn, $country_query);
            ?>
            <option value=1>Any</option>
            <?php 
                if ($countries) {
                    while ($row = mysqli_fetch_array($countries)) {
                        $country = $row['location'];
                        echo"<option value=$country>$country</option>";
                    }
                }
            ?>
        </select>
        <br>
        <label for="start_date" required>Start:</label>
        <input type="date" id="start_date" name="start_date" required>
        <br>
        <label for="start_date">End:</label>
        <input type="date" id="start_date" name="end_date" required>
        <br>
        <input type="submit" name="condition">
    </form>

    <?php 
        if (isset($_POST['condition'])) {
            $selected_city_condition = mysqli_escape_string($conn,$_POST['city']);
            $selected_city = ($selected_city_condition == 1) ? "" : " WHERE location = '$selected_city_condition'";
            $select_hotel_query = "SELECT * FROM hotels" . $selected_city;
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