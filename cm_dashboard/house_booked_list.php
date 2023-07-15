<?php 
  include '../session.php';

  	if (!isset($_SESSION['customer_id'])) {
            header('location: ../customer_login.php');
    } else{

      	include '../database/db.php';

	    $query              = "SELECT * FROM house_booked_list WHERE customer_id = {$_SESSION['customer_id']}";
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

        $queryHouse              = "UPDATE house SET status=0 WHERE id=:house_id";
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

  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php include 'partials.php' ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>House Booked List</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active"> All Booked List</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <h5 class="card-title">House Booked List</h5>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">House owner</th>
                    <th scope="col">House name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Booking Amount</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Txn ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                  
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
                    <td><?php echo $row['owner_name']; ?></td>
                    <td><?php echo $rowHouse['name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['payment']; ?></td>
                    <td><?php echo $row['txn_id']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td>
                      
                      <div class="badges">
                        <?php if ($row['approval'] == 0) { ?>
                        <button type="button" class="btn btn-sm">Pending</button>
                        <?php }elseif ($row['approval'] == 1) { ?>
                        <button type="button" class="btn btn-sm">Approved</button>
                        <?php } else{ ?>
                        <button type="button" class="btn btn-sm">Reject</button>
                        <?php } ?>
                      </div>
                    </td>
                    

                    <td>
                    	<form action="house_booked_list.php" method="POST">
          							<div class="card-image">
                          <input name='id' type='hidden' value="<?php echo $row['id']; ?>">
          
          							
          							</div>
          						</form>
                    </td>
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