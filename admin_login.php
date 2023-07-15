<?php
	include 'session.php';

	if(isset($_SESSION['admin_id'])){
		header("Location: dashboard/index.php");
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){

		$email = $_POST['email'];
		$password = $_POST['password'];

		include 'database/db.php';

		$query              = "SELECT * FROM admin";
        $stmt               = $db->prepare($query);
        $result             = $stmt->execute();
        $row                = $stmt->fetch();


        if ($email == $row['email'] && $password == $row['password']) { 
			$_SESSION['admin_id'] = $row['id'];
			$_SESSION['admin_name'] = $row['name'];
			$_SESSION['admin_photo'] = $row['photo'];
            header("Location: dashboard/index.php");
        } else{
        	?><script type="text/javascript">alert("Credentials mismatch!");header("Location: admin_login.php");</script><?php
        	
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
	<title>House Rent - Login</title>
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
							<h1 class="fs-4 card-title fw-bold mb-4">Login - Admin</h1>
							<form method="POST" action="admin_login.php" class="needs-validation" novalidate="" autocomplete="off" >
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
									<button type="submit" name="login" class="btn btn-primary">
										Login
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
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
