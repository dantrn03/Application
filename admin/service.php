<?php
    session_start();
    @ include 'navbar.php';
    @ include '../db_conn.php';
    @ include 'functions.php';
    
    if (isset($_POST['delete_service'])) {
        // echo "almost delete success";
        if (isset($_POST['chosen_services'])) {
            // echo '<script>alert("Are you sure to proceed")</script>';
            $deleteServiceQuery = "DELETE FROM services WHERE service_id = " . $_POST['chosen_services'][0];
            // echo $delete_query;
            for ($i = 1; $i < count($_POST['chosen_services']); $i++) {
                $deleteServiceQuery = $deleteServiceQuery . " OR service_id = " . $_POST['chosen_services'][$i];
            }
            mysqli_query($conn, $deleteServiceQuery);
            // echo $deleteServiceQuery;
            echo "<br>";
        } else {
            echo '<script>alert("Must pick at least one service to delete")</script>';
        }
    }

    if (isset($_POST['add_service'])) {
        // echo "adding service";
        if ($_POST['name'] == "" || $_POST['description'] == "") {
            echo "Invalid input";
            // echo "<script>confirm(\"Press a button!\");</script>";
        } else {
            $dum = "SELECT name FROM services WHERE name = '" . $_POST['name'] . "'";
            $dumRes = mysqli_query($conn, $dum);
            if (mysqli_num_rows($dumRes) > 0) {
                echo "Service already existed";
            } else {
                $addServiceQuery = "INSERT INTO services (name, description) VALUES ('" . $_POST['name'] . "','" . $_POST['description'] . "')";
                mysqli_query($conn, $addServiceQuery);
                // echo $addServiceQuery;
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
    <!-- service! -->
    <form method="post">
        <?php createDeleteServiceForm() ?>
        <input type="submit" name="delete_service" value="Delete">
    </form>
    <form method = "post">
     	<input type="text" name="name" placeholder="Name"><br>
     	<input type="text" name="description" placeholder="Description"><br>
        <input type="submit" name="add_service" value="add">
    </form>
</body>
</html>