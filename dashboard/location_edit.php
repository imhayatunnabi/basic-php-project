<?php 
  include '../session.php';

  if (!isset($_SESSION['admin_id'])) {
            header('location: ../admin_login.php');
    } else{

      if(!isset($_REQUEST['id'])){
          header('location: location.php');
      }

      include '../database/db.php';

	    $id  = $_REQUEST['id'];

	    //edit into database
	    $query              = "SELECT * FROM location WHERE id=:id";
	    $stmt               = $db->prepare($query);
	    $stmt               -> bindValue(':id',$id, PDO::PARAM_STR);
	    $result             = $stmt->execute();
	    $row                = $stmt->fetch();
    }


    if (isset($_POST['edit'])){

    	include '../database/db.php';

    	$id = $_POST['id'];	
		$name = $_POST['name'];
		

        //update into database
        $query      = "UPDATE location SET name = :name WHERE id   = :id";
        			
    	$stmt 	  = $db->prepare($query);

        $stmt     -> bindValue(':name',$name,PDO::PARAM_STR);
        $stmt     -> bindValue(':id',$id,PDO::PARAM_STR);

    	$result   = $stmt->execute();

    	if ($result) {
    		?><script type="text/javascript">alert("Location edited successfully.");</script><?php
    	}else{
    		?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
    	}
    	?><script type="text/javascript">location.href = 'location.php';</script><?php
	}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Edit Location</title>
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
      <h1>Location</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active"> Edit Location</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

     
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Location</h5>

              <form action="" method="POST" class="row g-3 needs-validation" novalidate>

              	<input name='id' type='hidden' value="<?php echo $id;?>">
                
                <div class="col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" id="name" required value="<?php echo $row['name']; ?>">
                  <div class="invalid-feedback">
                    Please provide a name.
                  </div>
                </div>


                <div class="col-12">
                  <button class="btn btn-primary" type="submit" name="edit">Add</button>
                </div>
              </form>

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

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>