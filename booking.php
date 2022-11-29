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
        echo "</div><br><div><label>Service </label> <br>";
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
            // echo "condition";
            // $selected_service_condition = mysqli_escape_string($conn, $_POST['service']);
            // echo "Hiii" . $selected_city_condition. " " . $selected_service_condition . "<br>";
            // $selected_city = ($selected_city_condition == 0) ? "" : " WHERE location = '$selected_city_condition'";
            // foreach($_POST['chosen_services'] as $value) {
            //     // $insert_details_query = "INSERT INTO details (reservation_id, hotel_id, room_no) VALUES (" . $last_id . "," . $_SESSION['chosen_hotel_id'] . "," . $value . ")" ;
            //     // mysqli_query($conn, $insert_details_query);
            //     // echo $value . "<br>";
            //     echo $value. "<br>";
            // }
            // echo sizeof($_POST['chosen_services']);
            $condition = "";
            if ($selected_city_condition != 0 && isset($_POST['chosen_services'])) {
                $condition = " WHERE location = '$selected_city_condition' AND hotel_id IN (
                    SELECT 
                        hotel_id 
                    FROM 
                        provide
                    WHERE 
                    ";
                $condition = $condition . "service_id = " . $_POST['chosen_services'][0];
                for ($i = 1; $i < count($_POST['chosen_services']); $i++) {
                    $condition = $condition . " OR service_id = " . $_POST['chosen_services'][$i];
                }
                $condition = $condition . ")";
            } else if ($selected_city_condition != 0) {
                $condition = " WHERE location = '$selected_city_condition'";
            } else if (isset($_POST['chosen_services'])) {
                $condition = " WHERE hotel_id IN (
                    SELECT 
                        hotel_id 
                    FROM 
                        provide
                    WHERE 
                    ";
                $condition = $condition . "service_id = " . $_POST['chosen_services'][0];
                for ($i = 1; $i < count($_POST['chosen_services']); $i++) {
                    $condition = $condition . " OR service_id = " . $_POST['chosen_services'][$i];
                }
                $condition = $condition . ")";
            } 
            // echo $condition;
            // echo $selected_city;
            $select_hotel_query = "SELECT * FROM hotels" . $condition;
            echo $select_hotel_query;
            $hotels = mysqli_query($conn, $select_hotel_query);
            $_SESSION['start_date'] = $_POST['start_date'];
            $_SESSION['end_date'] = $_POST['end_date'];
            if ($_POST['start_date'] >= $_POST['end_date']) {
                $error[] = 'date from must before date to';
            } else {
                createHotels($hotels, $_SESSION['start_date'], $_SESSION['end_date']); 
            }
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            };

        }
        if(isset($_POST['book_hotel'])){
            $_SESSION['chosen_hotel_id'] =  $_POST['chosen_hotel_id'];
            header('location:pick_room.php');
        }
    ?>
</body>
</html>