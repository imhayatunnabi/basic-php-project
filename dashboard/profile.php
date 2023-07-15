<?php 
  include '../session.php';

  	if (!isset($_SESSION['admin_id'])) {
            header('location: ../admin_login.php');
    } else{

      	include '../database/db.php';

	    $query    = "SELECT * FROM admin WHERE id = {$_SESSION['admin_id']}";
	    $stmt     = $db->prepare($query);
	    $result   = $stmt->execute();
	    $row      = $stmt->fetch();
    }

    if (isset($_POST['update-profile'])){

    	include '../database/db.php';
    	
		$name = $_POST['name'];

		if($_FILES['photo']['size'] != 0 && $_FILES['photo']['error'] == 0){
			$tmp_photo   = $_FILES["photo"]["tmp_name"];
	    	$photo       = $_FILES["photo"]["name"];


	    	//image upload
	    	$target_dir  = "assets/img/profile-image/";
	        $target_file = $target_dir . basename($photo);
	        $target_file = bin2hex(random_bytes(8));
	        $target_file = hash_hmac('sha256', $target_file, 'rentcar');
	        
	        $uploadOk    = 1;

	        $imageFileType  = pathinfo($target_file,PATHINFO_EXTENSION);
	        $check          = getimagesize($tmp_photo);



	        if($check !== false) {
	            $uploadOk = 1;
	            if (file_exists($target_file)) {
	                $uploadOk = 0;
	            }

	            if ($uploadOk == 0) {
	            
	            } else {
	                $uploadOk = 1;
	                $extension      = 'jpg';

	                $prod           = $target_file;
	                $newfilename    = $prod .".".$extension;

	                move_uploaded_file($tmp_photo, $target_dir.$newfilename);

                  $_SESSION['admin_photo'] = $newfilename;

	            }
	        }

		} else{
			$queryProfile  = "SELECT * FROM admin WHERE id = {$_SESSION['admin_id']}";
	    	$stmtProfile   = $db->prepare($query);
	    	$resultProfile = $stmtProfile->execute();
	    	$rowProfile    = $stmtProfile->fetch();

        $newfilename   = $rowProfile['photo'];

    }
        
		

      //update into database
      $query    = "UPDATE admin SET name = :name, photo = :photo WHERE id   = :id";
        			
    	$stmt 	  = $db->prepare($query);

      $stmt     -> bindValue(':name',$name,PDO::PARAM_STR);
      $stmt     -> bindValue(':photo',$newfilename,PDO::PARAM_STR);
      $stmt     -> bindValue(':id',$_SESSION['admin_id'],PDO::PARAM_STR);

    	$result   = $stmt->execute();

    	if ($result) {
    		?>
    		<script type="text/javascript">alert("Profile updated successfully."); location.href = 'profile.php';</script>
    		<?php
    	}else{
    		?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
    	}
    	?><script type="text/javascript">location.href = 'profile.php';</script><?php
	}

	if (isset($_POST['update-password'])) {

		include '../database/db.php';

	    $query    = "SELECT * FROM admin WHERE id = {$_SESSION['admin_id']}";
	    $stmt     = $db->prepare($query);
	    $result   = $stmt->execute();
	    $row      = $stmt->fetch();

		$password = $_POST['password'];

		$current_pass 	= $_POST['password'];
		$newpassword 	= $_POST['newpassword'];
		$renewpassword 	= $_POST['renewpassword'];

		if($password != $current_pass){
			?><script type="text/javascript">alert("Current password did not match.");</script><?php

		} elseif($newpassword != $renewpassword){
			?><script type="text/javascript">alert("New password & confirm passowrd did not match.");</script><?php

		} else{
			//update into database
	        $query= "UPDATE admin SET password = :password WHERE id = :id";
	        			
	    	$stmt = $db->prepare($query);

	        $stmt -> bindValue(':password',$newpassword,PDO::PARAM_STR);
	        $stmt -> bindValue(':id',$_SESSION['admin_id'],PDO::PARAM_STR);

	    	$result  = $stmt->execute();

	    	if ($result) {
	    		?>
	    		<script type="text/javascript">alert("Password updated successfully."); location.href = 'profile.php';</script>
	    		<?php
	    	}else{
	    		?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
	    	}
	    	?><script type="text/javascript">location.href = 'profile.php';</script><?php
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Profile</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php include 'partials.php' ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active"> Profile</li>
        </ol>
      </nav>
    </div>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/profile-image/<?php echo $row['photo']; ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $row['name']; ?></h2>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
             
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['email']; ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                 
                  <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="file" class="form-control" name="photo" id="photo">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="fullName" value="<?php echo $row['name']; ?>">
                      </div>
                    </div>
                    

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="email" class="form-control" id="Email" value="<?php echo $row['email']; ?>" disabled>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="update-profile" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="profile.php" method="POST">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="update-password" class="btn btn-primary">Change Password</button>
                    </div>
                  </form>

                </div>

              </div>

            </div>
          </div>

        </div>
      </div>
    </section>


  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!--  Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>