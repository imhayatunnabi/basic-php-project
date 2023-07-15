<?php
  include '../session.php';
  if (!isset($_SESSION['customer_id'])) {
            header('location: ../customer_login.php');
  }

  include '../database/db.php';

  include 'cm_details.php';

  $queryHouseBook    = "SELECT * FROM house_booked_list WHERE customer_id = {$rowCM['id']}  ORDER BY date DESC LIMIT 10";
  $stmtHouseBook     = $db->prepare($queryHouseBook);
  $resultHouseBook   = $stmtHouseBook->execute();


  $queryHouseBookedCount    = "SELECT COUNT(*) FROM house_booked_list WHERE customer_id = {$rowCM['id']}";
  $stmtHouseBookedCount     = $db->prepare($queryHouseBookedCount);
  $resultHouseBookedCount   = $stmtHouseBookedCount->execute();
  $resultHouseBookedCount   = $stmtHouseBookedCount->fetchColumn();

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        
        <div class="col-lg-12">
          <div class="row">

         
            <div class="col-xxl-6 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Total House Booked</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-card-checklist"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $resultHouseBookedCount; ?></h6>

                    </div>
                  </div>
                </div>

              </div>
            </div>

           
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Booked List </h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Sl</th>
                        <th scope="col"> Customer Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">House owner</th>
                        <th scope="col">House name</th>
                        <th scope="col"> House Location</th>
                        <th scope="col">Address</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Txn ID</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                  $i = 1;
                  while($row  = $stmtHouseBook->fetch()){ 
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
                    <td><?php echo $rowHouse['location']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['payment']; ?></td>
                    <td><?php echo $row['txn_id']; ?></td>
                    <td>
                      <?php if ($row['approval'] == 0) { ?>
                      <button type="button" class="btn btn-sm">Pending</button>
                      <?php } elseif ($row['approval'] == 1) { ?>
                      <button type="button" class="btn btn-sm">Approved</button>
                      <?php } else{ ?>
                      <button type="button" class="btn btn-sm">Rejected</button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
                    </tbody>
                  </table>

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

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>