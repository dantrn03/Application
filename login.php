<?php
@include 'db_conn.php';
session_start();

if(isset($_POST['login'])){
	$username = mysqli_real_escape_string($conn,$_POST['email']);
	$pass = mysqli_real_escape_string($conn,$_POST['password']);
	$account = "SELECT * FROM users WHERE email = '$username' && password = '$pass'";
	$result = mysqli_query($conn, $account);
	if(mysqli_num_rows($result)>0){
		$user = mysqli_fetch_array($result);
		$_SESSION['name'] = $user['first_name'];
		$_SESSION['user_id'] = $user['user_id'];
		if ($user['account_type'] == "user") {
			header('location:user/home.php');
		} else {
			header('location:admin/home.php');
		}
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
	<header>
		<h1>Make My Stay</h1>
	</header>
     <form action="login.php" method="post">
     	<h2>LOGIN</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<label>User Name</label>
     	<input type="text" name="email" placeholder="User Name"><br>

     	<label>Password!!</label>
     	<input type="password" name="password" placeholder="pass!"><br>
		<input type="submit" name="login" value="login">
		<p>Don't have an account? <a href="register.php">register now</a></p>
     </form>
</body>
</html>
