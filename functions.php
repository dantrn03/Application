<?php

function createHotels($hotels, $start_date, $end_date) {
    @include 'db_conn.php';
    while ($row = mysqli_fetch_array($hotels)) {
        $available_rooms = getAllRooms($row, $start_date, $end_date);
        // $tmp = getAllRooms($row, $start_date, $end_date);
        $rooms_left = 0;
        $capacity = 0;

        // echo getRoomsLeft($tmp);

        while ($rrow = mysqli_fetch_array($available_rooms)) {
            echo $rrow['hotel_id']. ": " . $rrow['room_no'] . ", " . $rrow['price_per_night'] . "<br>";
            $rooms_left++;
            $capacity += $rrow['no_of_people'];
        }

        
        echo $rooms_left . " " . $capacity;


        $hoe = $row['hotel_id'];
        $hoe_name = $row['name'];
        $service = $row['service_id'];
        $service_query = "SELECT name FROM services WHERE service_id='$service'";
        $service_res = mysqli_query($conn, $service_query);
        $service_row = mysqli_fetch_array($service_res);
        $service_name = $service_row['name'];
        $element = "
        <form class=\"div-box\"  /*action=\"pick_room.php\"*/ method=\"POST\" >
        <div class=\"child1\"><p>$service_name</p></div>
        <div class=\"child2\">
            <p>$hoe_name</p>
            <input type=\"submit\" class=\"\" name=\"book_hotel\" value=\"Buy Now\"></input>
            <input type=\"hidden\" name =\"chosen_hotel_id\" value=$hoe  >
        </div>
        </form>
        ";
        echo $element;
        // echo $start_date < $end_date ? "true" : "false";
    }
}

function getAllRooms($row, $start_date, $end_date) {
    @include 'db_conn.php';


    $hoe_name = $row['hotel_id'];
    $available_rooms_query = "
        SELECT *
        FROM rooms 
        WHERE hotel_id=$hoe_name
        AND room_no 
        NOT IN (
            SELECT room_no 
            FROM (
                SELECT details.reservation_id as reservation_id,
                reservations.date_from, reservations.date_to, 
                details.room_no, reservations.hotel_id
                FROM details 
                LEFT JOIN reservations 
                ON details.reservation_id = reservations.reservation_id
            ) as a
            WHERE hotel_id = $hoe_name
            AND NOT(DATE(date_to) <= '$start_date'
                OR DATE(date_from) >= '$end_date')
        )";
    $available_rooms_res = mysqli_query($conn, $available_rooms_query);
    // while ($rrow = mysqli_fetch_array($available_rooms_res)) {
    //     echo $rrow['room_no']. "<br>";
    // }
    return $available_rooms_res;

    // SELECT 
}

function getRoomsLeft($available_rooms) {
    @include 'db_conn.php';
    // $query = "SELECT COUNT(*) as rooms_left FROM rooms ";
    $res = 0;
    while (mysqli_fetch_array($available_rooms)) {
        $res++;
    }
    return $res;
}

function getCapacityLeft($available_rooms) {

}

function createRoomsSelection() {

}