<?php
    include 'navbar.php';
    include 'db_conn.php';
    $query = "SELECT name, description FROM services";
    $res = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="main_theme.css">
</head>
<body>
    <h1>Service</h1>
    <?php 
        if ($res) {
            echo "<table><tr><th>Name</th><th>Description </th><tr/>";
            while ($row = mysqli_fetch_array($res)) {
                $name = $row['name'];
                $description = $row['description'];
                echo "<tr>
                        <td>$name</th>
                        <td>$description </th>
                    <tr/>
                    ";
                // echo"<p>$name: $description</p>";
            }
        }
    ?>
</body>
</html>