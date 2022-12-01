<?php

function createDeleteServiceForm() {
    @include '../db_conn.php';
    $query = "SELECT * FROM services";
    // $query_res = mysqli_query($conn, $query);
    // if ($query_res) {
    //     while ($row = mysqli_fetch_array($query_res)) {
    //         $service_name = $row['name'];
    //         echo "<input type = checkbox name=\"chosen_services[]\" value=" . $row['service_id']  . "> $service_name <br>";
    //     }
    // }
    createCheckboxesFromQuery($query, "chosen_services", "service_id", "name");
}

function createCheckboxesFromQuery($query, $name, $value, $display) {
    @include '../db_conn.php';
    $query_res = mysqli_query($conn, $query);
    if ($query_res) {
        while ($row = mysqli_fetch_array($query_res)) {
            echo "<input type = checkbox name=\"" . $name . "[]\" value=" . $row[$value]  . ">" . $row[$display] . "<br>";
        }       
    } else {
        echo "fail";
    }
}
