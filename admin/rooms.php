<?php
    session_start();
    @ include 'navbar.php';
    @ include '../db_conn.php';
    @ include 'functions.php';
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
    <form method="post">
        <?php
            $hotel_query = "SELECT hotel_id, name FROM hotels";
            $hotel_res = mysqli_query($conn, $hotel_query);
            echo "<select class = \"condition\" id=\"hotelIDs\" name=\"hotel\">";
            // <option value=0>Any</option>";
            if ($hotel_res) {
                while ($row = mysqli_fetch_array($hotel_res)) {
                    // $country = $row['location'];
                    echo"<option value=" . $row['hotel_id'] . ">" . $row['name'] . "</option>";
                }
            }
            echo "</select>"; 
        ?>
        <input type="submit" name="pickHotel" value="Next">
    </form>
    <?php
        if (isset($_POST['pickHotel'])) {
            $_SESSION['chosen_hotel_to_modify_room'] = $_POST['hotel'];
            echo $_SESSION['chosen_hotel_to_modify_room'];
            echo 
            "<form method=\"post\">
                <input type=\"text\" name=\"roomNum\" placeholder=\"Room Number\"><br>
                <input type=\"text\" name=\"price\" placeholder=\"Price Per Nigh\"><br>
                <input type=\"text\" name=\"capacity\" placeholder=\"Max Number of People\"><br>
                <input type=\"submit\" name=\"addRoom\" value=\"Add\">
            </form>
            <form method=\"post\">";
            $existedRoomsQuery = "SELECT room_no, hotel_id FROM rooms WHERE hotel_id = " . $_SESSION['chosen_hotel_to_modify_room'];
            createCheckboxesFromQuery($existedRoomsQuery, "chosenRooms", "room_no", "room_no");
            echo "<input type=\"submit\" name=\"deleteRoom\" value=\"Delete\">
            </form>";
            echo $existedRoomsQuery;
        }
        if (isset($_POST['addRoom'])) {
            if (!is_numeric($_POST['roomNum']) || $_POST['roomNum'] <= 0 || $_POST['roomNum'] - (int)$_POST['roomNum'] != 0 
            || !is_numeric($_POST['capacity']) || $_POST['capacity'] <= 0 || $_POST['capacity'] - (int)$_POST['capacity'] != 0
            || !is_numeric($_POST['price']) || $_POST['price'] <= 0 || $_POST['price'] - (int)$_POST['price'] != 0) {
                echo "Invalid input";
            } else {
                $addRoomQuery = "INSERT INTO rooms (room_no, hotel_id, price_per_night, no_of_people) VALUES (" . $_POST['roomNum'] . "," . $_SESSION['chosen_hotel_to_modify_room'] . "," . $_POST['price'] . "," . $_POST['capacity'] . ")";
                mysqli_query($conn, $addRoomQuery);
                echo $addRoomQuery;
            }
        }
        if (isset($_POST['deleteRoom'])) {
            $deleteRoomQuery = "DELETE FROM rooms WHERE hotel_id = " . $_SESSION['chosen_hotel_to_modify_room'] . " AND (room_no = " . $_POST['chosenRooms'][0];
            for ($i = 1; $i < count($_POST['chosenRooms']); $i++) {
                $deleteRoomQuery = $deleteRoomQuery . " OR room_no = " . $_POST['chosenRooms'][$i];
            }
            $deleteRoomQuery = $deleteRoomQuery . ")";
            mysqli_query($conn, $deleteRoomQuery);
            echo $deleteRoomQuery;
        }
    ?>
</body>
</html>