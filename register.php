<?php

@include 'db_conn.php';

if(isset($_POST['submit'])){

   $first_name = mysqli_real_escape_string($conn, $_POST['fname']);
   $last_name = mysqli_real_escape_string($conn, $_POST['lname']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);

   $select = " SELECT * FROM users WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $account_type = "";
         if ($_POST['account_type'] == 0) {
            $account_type = "user";
         } else {
            $account_type = "admin";
         }

         $insert = "INSERT INTO users(email, password, first_name, last_name, account_type) VALUES('$email','$pass','$first_name','$last_name','$account_type')";
         mysqli_query($conn, $insert);
         header('location:login.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" type="text/css" href="login.css">

</head>
<body>
    <div class="form-container">

    <form action="" method="post">
      <h2>Register now</h2>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="fname" required placeholder="enter your first name">
      <input type="text" name="lname" required placeholder="enter your last name">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="account_type">
         <option value=0>user</option>
         <option value=1>admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

    </div>
</body>
</html>