<?php 
  include '../session.php';

  	if (!isset($_SESSION['house_owner_id'])) {
            header('location: ../login.php');
    } else{

      	include '../database/db.php';
        include 'hw_details.php';

	    $query              = "SELECT * FROM house_booked_list WHERE owner_name = '{$rowHW['name']}' AND approval=0";
	    $stmt               = $db->prepare($query);
	    $result             = $stmt->execute();
    }

    if (isset($_POST['delete'])){

    	include '../database/db.php';

      $id = $_POST['id'];
    	$house_id = $_POST['house_id'];

    	$query   = "DELETE FROM house_booked_list WHERE id=:id";
      $stmt    = $db->prepare($query);
      $stmt    -> bindValue(':id',$id, PDO::PARAM_STR);
      $result  = $stmt->execute();


      $queryHouse    = "UPDATE house SET status=1 WHERE id=:house_id";
      $stmtHouse     = $db->prepare($queryHouse);
      $stmtHouse     -> bindValue(':house_id',$house_id, PDO::PARAM_STR);
      $resultHouse   = $stmtHouse->execute();

        if ($result) {
    		?><script type="text/javascript">alert("House booked list deleted.");</script><?php
    		header("Refresh:0");
    	}else{
    		?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
    	}

    }

    if (isset($_POST['approved'])){

      include '../database/db.php';

        $id = $_POST['id'];
        $house_id = $_POST['house_id'];

        $query              = "UPDATE house_booked_list SET approval=1 WHERE id=:id";
        $stmt               = $db->prepare($query);
        $stmt               -> bindValue(':id',$id, PDO::PARAM_STR);
        $result             = $stmt->execute();

        $queryHouse              = "UPDATE house SET status=2 WHERE id=:house_id";
        $stmtHouse               = $db->prepare($queryHouse);
        $stmtHouse               -> bindValue(':house_id',$house_id, PDO::PARAM_STR);
        $resultHouse             = $stmtHouse->execute();

        if ($result) {
        ?><script type="text/javascript">alert("House booked item is approved.");</script><?php
        header("Refresh:0");
      }else{
        ?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
      }

    }

    if (isset($_POST['disapproved'])){

      include '../database/db.php';

        $id = $_POST['id'];
        $house_id = $_POST['house_id'];

        $query              = "UPDATE house_booked_list SET approval=2 WHERE id=:id";
        $stmt               = $db->prepare($query);
        $stmt               -> bindValue(':id',$id, PDO::PARAM_STR);
        $result             = $stmt->execute();

        $queryHouse              = "UPDATE house SET status=1 WHERE id=:house_id";
        $stmtHouse               = $db->prepare($queryHouse);
        $stmtHouse               -> bindValue(':house_id',$house_id, PDO::PARAM_STR);
        $resultHouse             = $stmtHouse->execute();

        if ($result) {
        ?><script type="text/javascript">alert("House booked item is disapproved.");</script><?php
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

  <title>Dashboard - House Booked List</title>
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
      <h1>Parts Booked List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active"> All Booked List</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <h5 class="card-title">House Booked List</h5>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Sl</th>
                    <th scope="col"> Customer Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">House Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Txn ID</th>
                    <th scope="col">Approval</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                	$i = 1;
        					while($row  = $stmt->fetch()){ 
                    $queryHouse   = "SELECT * FROM house WHERE id={$row['house_id']}";
                    $stmtHouse    = $db->prepare($queryHouse);
                    $resultHouse  = $stmtHouse->execute();
                    $rowHouse     = $stmtHouse->fetch();
                    ?>
                  <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $rowHouse['name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['payment']; ?></td>
                    <td><?php echo $row['txn_id']; ?></td>
                    <td>
                      <?php if($row['approval'] == 0){ ?>
                      <form action="house_booked_list.php" method="POST">
                        <div class="card-image">
                          <input name='id' type='hidden' value="<?php echo $row['id']; ?>">
                          <input name='house_id' type='hidden' value="<?php echo $row['house_id']; ?>">

                          <button class="btn btn-success btn-sm" type="submit" name="approved" >Approve</button>
                          <button class="btn btn-danger btn-sm" type="submit" name="disapproved">Reject</button>
                          
                        </div>
                      </form>

                      <div class="badges">
                        <?php } elseif ($row['approval'] == 1) { ?>
                        <button type="button" class="btn btn-success btn-sm">Approved</button>
                        <?php } else{ ?>
                        <button type="button" class="btn btn-danger btn-sm">Disapproved</button>
                        <?php } ?>
                      </div>
                    </td>

                    <td>
                    	<form action="house_booked_list.php" method="POST">
          							<div class="card-image">
                          <input name='id' type='hidden' value="<?php echo $row['id']; ?>">
          								<input name='house_id' type='hidden' value="<?php echo $row['house_id']; ?>">
          								
                          <a class="btn btn-primary btn-sm" target="_blank" href="/houserent/cm_dashboard/print.php?hb_id=<?php echo $row['id']; ?>">DETAILS </a>
          							</div>
          						</form>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>

            </div>
          </div>

        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>