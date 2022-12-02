<?php
    session_start();
    @ include 'navbar.php';
    @ include '../db_conn.php';
    @ include 'functions.php';

    if (isset($_POST['delete_hotel'])) {
        // echo "almost delete success";
        if (isset($_POST['chosenHotels'])) {
            // echo '<script>alert("Are you sure to proceed")</script>';
            $deleteHotelQuery = "DELETE FROM hotels WHERE hotel_id = " . $_POST['chosenHotels'][0];
            // echo $delete_query;
            for ($i = 1; $i < count($_POST['chosenHotels']); $i++) {
                $deleteHotelQuery = $deleteHotelQuery . " OR service_id = " . $_POST['chosenHotels'][$i];
            }
            mysqli_query($conn, $deleteHotelQuery);
            $additionaldeletequery = "DELETE FROM reservations WHERE reservation_id NOT IN (SELECT reservation_id FROM details)";
            mysqli_query($conn, $additionaldeletequery);
            // echo $deleteHotelQuery;
            echo "<br>";
        } else {
            echo '<script>alert("Must pick at least one hotel to delete")</script>';
        }
    }

    if (isset($_POST['add_hotel'])) {
        // echo "adding service";
        if ($_POST['name'] == "" || $_POST['location'] == "") {
            echo "ERROR";
            // echo "<script>confirm(\"Press a button!\");</script>";
        } else {
            $checkHotelsQuery = "SELECT name FROM hotels WHERE name = '" . $_POST['name'] . "'";
            $checkHotelsRes = mysqli_query($conn, $checkHotelsQuery);
            if(mysqli_num_rows($checkHotelsRes) > 0){
                echo "Hotel already existed";
          
            } else {
                $addHotelQuery = "INSERT INTO hotels (name, location) VALUES ('" . $_POST['name'] . "','" . $_POST['location'] . "')";
                mysqli_query($conn, $addHotelQuery);
                // echo $addHotelQuery;
                echo "<br>";
            }
        } 
    }
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
    <form method = "post">
     	<input type="text" name="name" placeholder="Name"><br>
     	<input type="text" name="location" placeholder="Location"><br>
        <input type="submit" name="add_hotel" value="add">
    </form>
    <form method="post">
        <?php 
            $hotel_query = "SELECT hotel_id, name FROM hotels";
            createCheckboxesFromQuery($hotel_query, "chosenHotels", "hotel_id", "name");
        ?>
        <input type="submit" name="delete_hotel" value="Delete">
    </form>

</body>
</html>