<?php
	include 'session.php';

	if(isset($_SESSION['house_owner_id'])){
		header("Location: hw_dashboard/index.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){

		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$photo = 'profile.jpg';

		include 'database/db.php';

		$query    = "SELECT COUNT(*) FROM house_owner WHERE email = '{$email}'";
	    $stmt     = $db->prepare($query);
	    $result   = $stmt->execute();
	     $row      = $stmt->fetchColumn();

	  if($row){
	  	?><script type="text/javascript">alert("Email already taken!"); location.href = 'login.php';</script><?php

	  } else{

	  	if(!empty($name) && !empty($email) && !empty($password)){
	  		$query    = "INSERT INTO house_owner(name, email, password, photo) VALUES(:name, :email, :password, :photo)";
                
	      $stmt     = $db->prepare($query);

	      $stmt     -> bindValue(':name',$name,PDO::PARAM_STR);
	      $stmt     -> bindValue(':email',$email,PDO::PARAM_STR);
	      $stmt     -> bindValue(':password',$password,PDO::PARAM_STR);
	      $stmt     -> bindValue(':photo',$photo,PDO::PARAM_STR);

	      $result   = $stmt->execute();

	      if ($result) {
	        ?><script type="text/javascript">alert("Registration successful!"); location.href = 'login.php';</script><?php
	      }else{
	        ?><script type="text/javascript">alert("Oops! something went wrong!");</script><?php
	      }

	  	} else{
	  		?><script type="text/javascript">alert("Field must not be empty!");</script><?php
	  	}
	  	
	  }

				
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>House Rent - Signup</title>
	<link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="logo.png" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Signup - House Owner</h1>
							<form method="POST" action="signup.php" class="needs-validation" novalidate="" autocomplete="off" >
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email"required>Name</label>
									<input id="name" type="text" class="form-control" name="name" value="" required autofocus>
									<div class="invalid-feedback">
										Name Required
									</div>
								</div>
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" name="signup" class="btn btn-primary">
										Signup
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0 text-center">
							<p>Already registerd? <a href="login.php">Login</a></p>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; <?php echo date('Y'); ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/login.js"></script>
</body>
</html>
