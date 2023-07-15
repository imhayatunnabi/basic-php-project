<?php 
  include '../session.php';

  	if (!isset($_SESSION['house_owner_id'])) {
            header('location: ../login.php');
    } else{

      	include '../database/db.php';

	    $query              = "SELECT * FROM house WHERE owner_name = '{$_SESSION['house_owner_name']}'";
	    $stmt               = $db->prepare($query);
	    $result             = $stmt->execute();

	    $queryLocation      = "SELECT * FROM location";
	    $stmtLocation          = $db->prepare($queryLocation);
	    $resultLocation        = $stmtLocation->execute();
    }

    if (isset($_POST['delete'])){

    	include '../database/db.php';

    	$id = $_POST['id'];

    	   $query              = "DELETE FROM house WHERE id=:id";
        $stmt               = $db->prepare($query);
        $stmt               -> bindValue(':id',$id, PDO::PARAM_STR);
        $result             = $stmt->execute();

        if ($result) {
    		?><script type="text/javascript">alert("House deleted.");</script><?php
    		header("Refresh:0");
    	}else{
    		?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
    	}

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - House</title>
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

 
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php include 'partials.php' ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>House</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active"> All House</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <h5 class="card-title">All House</h5>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">House Name</th>
                    <th scope="col">Area</th>
                    <th scope="col">Room</th>
                    <th scope="col">Washroom</th>
                    <th scope="col">Price</th>
                    <th scope="col">Type</th>
                    <th scope="col">Location</th>
                    <th scope="col">Rent From</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                	$i = 1;
					        while($row  = $stmt->fetch()){?>
                  <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['area']; ?></td>
                    <td><?php echo $row['total_room']; ?></td>
                    <td><?php echo $row['total_washroom']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['house_type']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['rent_from']; ?></td>
                    <td>
                      <?php if ($row['status'] == 0) { ?>
                      <button type="button" class="btn btn-secondary btn-sm">Pending</button>
                      <?php } elseif ($row['status'] == 1) { ?>
                        <button type="button" class="btn btn-success btn-sm">Approved</button>
                        <?php } elseif ($row['status'] == 2){ ?>
                        <button type="button" class="btn btn-warning btn-sm">Booked</button>
                        <?php } elseif ($row['status'] == 3){ ?>
                        <button type="button" class="btn btn-secondary btn-sm">Pending Booking</button>
                        <?php } elseif ($row['status'] == 4){ ?>
                        <button type="button" class="btn btn-danger btn-sm">Disapproved</button>
                      <?php } ?>
                    </td>

                        

                    
                        <form action="house.php" method="POST">
                          <div class="card-image">
                            <input name='id' type='hidden' value="<?php echo $row['id']; ?>">
                            <td><a class="btn btn-primary btn-sm px-2" href="house_edit.php?id=<?php echo $row['id']; ?>">EDIT	</a></td>
                            
                            <td><button class="btn btn-danger btn-sm" type="submit" name="delete">DELETE</button> </td>
                            
                          </div>
                        </form>
                   
                  </tr>
                <?php } ?>
                </tbody>
              </table>

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