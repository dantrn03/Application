<?php

function createHotels($hotels, $start_date, $end_date) {
    // echo "Hell0";
    @include 'db_conn.php';
    while ($row = mysqli_fetch_array($hotels)) {
        $available_rooms = getAllRooms($row, $start_date, $end_date);
        $rooms_left = 0;
        $capacity = 0;

        while ($rrow = mysqli_fetch_array($available_rooms)) {
            // echo $rrow['hotel_id']. ": " . $rrow['room_no'] . ", " . $rrow['price_per_night'] . "<br>";
            $rooms_left++;
            $capacity += $rrow['no_of_people'];
        }

        // echo $rooms_left . " " . $capacity;

        $hoe = $row['hotel_id'];
        $hoe_name = $row['name'];
        // $service = $row['service_id'];
        $service_query = "SELECT name FROM provide INNER JOIN services ON provide.service_id = services.service_id WHERE hotel_id = $hoe";
        // echo $service_query;
        $service_res = mysqli_query($conn, $service_query);
        // $service_row = mysqli_fetch_array($service_res);
        // $service_name = $service_row['name'];
        $element = "
        <form class=\"div-box\"  /*action=\"pick_room.php\"*/ method=\"POST\" >
        <div><lable>Hotel</lable> <label class = \"var\">: $hoe_name </label> </div><br>
        <div> Service</lable> <label class = \"var\">: </label></div>";
        while ($service_detail = mysqli_fetch_array($service_res)) {
            $element = $element . $service_detail['name'] . "<br>";
        }
        $element = $element . "<br>";

        $element = $element . "<div>Rooms left </lable> <label class = \"var\">: $rooms_left</label></div><br>
        <div>Capacity left </lable> <label class = \"var\">: $capacity </label></div><br>
        <div>
            <input type=\"submit\" class=\"\" name=\"book_hotel\" value=\"Book Now\"></input>
            <input type=\"hidden\" name =\"chosen_hotel_id\" value=$hoe  >
        </div>
        </form>
        ";

        // <div> Service</lable> <label class = \"var\">: $service_name</label></div><br>
        echo $element;
    }
}

function getAllRooms($row, $start_date, $end_date) {
    @include 'db_conn.php';


    $hoe_name = $row['hotel_id'];
    $available_rooms_query = "
        SELECT 
            *
        FROM 
            rooms 
        WHERE 
            hotel_id=$hoe_name
            AND room_no NOT IN (
                SELECT 
                    room_no 
                FROM (
                    SELECT 
                        details.reservation_id as reservation_id,
                        reservations.date_from, 
                        reservations.date_to, 
                        details.room_no, 
                        details.hotel_id
                    FROM 
                        details 
                    LEFT JOIN 
                        reservations 
                    ON 
                        details.reservation_id = reservations.reservation_id
                ) as tmp
                WHERE 
                    hotel_id = $hoe_name
                AND NOT(
                    DATE(date_to) <= '$start_date'
                    OR DATE(date_from) >= '$end_date')
        )";
    $available_rooms_res = mysqli_query($conn, $available_rooms_query);
    return $available_rooms_res;
}

function getHistories($user_id) {
    @include 'db_conn.php';
    $query = "SELECT * FROM reservations WHERE user_id = $user_id";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($res)) {

        $rev_id = $row['reservation_id'];
        $rev_query = "SELECT * FROM details WHERE reservation_id = $rev_id";
        $rev_res = mysqli_query($conn, $rev_query);
        $tmp = mysqli_fetch_array($rev_res);
        $current_hotel_id = $tmp['hotel_id'];
        $hotel_name_query = "SELECT * FROM hotels WHERE hotel_id = $current_hotel_id";
        $hotel_name_res = mysqli_query($conn, $hotel_name_query);
        $tmp = mysqli_fetch_array($hotel_name_res);
        echo "<div class = \"history\"> Reservation id: <label class=\"var\">". $row['reservation_id'] . "</label><br>Hotel name:<label class=\"var\">" . $tmp['name']. " " . "</label><br>Rooms:";
        createHistory($row['reservation_id']);
        echo "</div><br>";
    }
    
}

function createHistory($reservation_id) {
    @include 'db_conn.php';
    $query = "SELECT * FROM details WHERE reservation_id = $reservation_id";
    $res = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($res)) {
        echo "<label class=\"var\">". $row['room_no'] . "</label><br>";

    }
}

function createReservation() {
    @include 'db_conn.php';
}

function createLocationSelection() {
    @include 'db_conn.php';

    $location_query = "SELECT DISTINCT location FROM hotels";
    $location_result = mysqli_query($conn, $location_query);
    echo "<select class = \"condition\" id=\"country_selection\" name=\"city\">
    <option value=0>Any</option>";
        if ($location_result) {
            while ($row = mysqli_fetch_array($location_result)) {
                $country = $row['location'];
                echo"<option value=$country>$country</option>";
            }
        }
    echo "</select>";
}

function createServiceSelection() {
    @include 'db_conn.php';
    // echo "Create serviceSelection";

    $service_query = "SELECT DISTINCT * FROM services";
    $service_result = mysqli_query($conn, $service_query);
    // echo "<select class = \"condition\" id=\"service_selection\" name=\"service\">
    // <option value=0>Any</option>";
    if ($service_result) {
        while ($row = mysqli_fetch_array($service_result)) {
            $service_id = $row['service_id'];
            $service_name = $row['name'];
            // echo"<option value=$service_id>$service_name</option>";
            echo "<input type = checkbox name=\"chosen_services[]\" value=" . $row['service_id']  . "> $service_name <br>";
        }
    }
    echo "</select>";
    // echo "complete";
}