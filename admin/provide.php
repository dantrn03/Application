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
        echo "<select id=\"hotelIDs\" name=\"hotel\">";
        // <option value=0>Any</option>";
        if ($hotel_res) {
            while ($row = mysqli_fetch_array($hotel_res)) {
                // $country = $row['location'];
                echo"<option value=" . $row['hotel_id'] . ">" . $row['name'] . "</option>";
            }
        }
        echo "</select>"; 
    ?>
    <br><br>
        <input type="submit" name="pickHotel" value="Next">
    </form>
    <?php
        if (isset($_POST['pickHotel'])) {
            $_SESSION['chosen_hotel_to_modify_service'] = $_POST['hotel'];
            echo "<form method=\"post\">";
            $newServiceQuery = "SELECT service_id, name FROM services WHERE service_id NOT IN (SELECT service_id FROM provide WHERE hotel_id = " . $_POST['hotel'] . ")";
            createCheckboxesFromQuery($newServiceQuery, "added_services", "service_id", "name");
            echo "<input class=\"submitButton\" type=\"submit\" name=\"addService\" value=\"Add\">
            </form>
            <form method=\"post\">";
            $existedServiceQuery = "SELECT services.service_id, name FROM services LEFT JOIN provide ON services.service_id = provide.service_id WHERE hotel_id = " . $_POST['hotel'];
            createCheckboxesFromQuery($existedServiceQuery, "deleted_services", "service_id", "name");
            echo "<input class=\"submitButton\" type=\"submit\" name=\"deleteService\" value=\"Delete\">
            </form>";
        }
        if (isset($_POST['addService'])) {
            if (!isset($_POST['added_services'])) {
                echo '<script>alert("Must pick at least one service")</script>';
            } else {
                $insertProvideQuery = "INSERT INTO provide (hotel_id, service_id) VALUES (" . $_SESSION['chosen_hotel_to_modify_service'] . "," . $_POST['added_services'][0] . ")";
                for ($i = 1; $i < count($_POST['added_services']); $i++) {
                    $insertProvideQuery = $insertProvideQuery . ", (" . $_SESSION['chosen_hotel_to_modify_service'] . ", " . $_POST['added_services'][$i] . ")";
                }
                mysqli_query($conn, $insertProvideQuery);
                // echo $insertProvideQuery;
            }
        }
        if (isset($_POST['deleteService'])) {
            if (!isset($_POST['deleted_services'])) {
                echo '<script>alert("Must pick at least one service")</script>';
            } else {
                $deleteProvideQuery = "DELETE FROM provide WHERE hotel_id = " . $_SESSION['chosen_hotel_to_modify_service'] . " AND (service_id = " . $_POST['deleted_services'][0];
                for ($i = 1; $i < count($_POST['deleted_services']); $i++) {
                    $deleteProvideQuery = $deleteProvideQuery . " OR service_id = " . $_POST['deleted_services'][$i] ;
                }
                $deleteProvideQuery = $deleteProvideQuery . ")";
                mysqli_query($conn, $deleteProvideQuery);
                // echo $deleteProvideQuery;
            }
        }
    ?>
</body>
</html>