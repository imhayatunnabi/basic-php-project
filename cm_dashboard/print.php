<?php 
  include '../session.php';

  	if (!isset($_SESSION['customer_id'])) {
            header('location: ../customer_login.php');
    } else{

      if(!isset($_REQUEST['hb_id'])){
        header('location: house_booked_list.php');
      }

      	include '../database/db.php';

        include 'cm_details.php';

        $house_booked_id = $_REQUEST['hb_id']; 

  	    $query       = "SELECT * FROM house_booked_list WHERE id = {$house_booked_id}";
  	    $stmt        = $db->prepare($query);
        $result      = $stmt->execute();
  	    $row         = $stmt->fetch();

        $queryHouse       = "SELECT * FROM house WHERE id = {$row['house_id']}";
        $stmtHouse        = $db->prepare($queryHouse);
        $resultHouse      = $stmtHouse->execute();
        $rowHouse         = $stmtHouse->fetch();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Print</title>
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

  <main id="main" class="main mx-0">


    <section class="section dashboard">
      <div class="row">

      
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <div class="main-content p-5">
                <section class="section">

                  <div class="section-body">
                    <div class="invoice">
                      <div class="invoice-print">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="invoice-title text-center">
                              <h2>Sweet Home</h2>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-md-6 col-lg-6">
                                <address>
                                  <strong>House booked by:</strong><br>
                                    <?php echo $rowCM['name'] ?><br>
                                    <?php echo $rowCM['email'] ?><br>
                                    <?php echo $rowCM['phone'] ?><br>
                                    <?php echo $rowCM['address'] ?><br>
                                </address>
                              </div>
                              <div class="col-md-6 col-lg-6">
                                <address>
                                  <strong>Payment Method:</strong><br>
                                  <?php echo $row['payment'] ?><br>
                                  Txn ID: <?php echo $row['txn_id'] ?><br>
                                </address>
                              </div>
                              <div class="col-md-6 col-lg-6 float-right">
                                <address>
                                  <strong>Booking Date:</strong><br>
                                  <?php echo $row['date'] ?><br><br>
                                </address>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-4">
                          <div class="col-md-12">
                            <div class="section-title">Booked Summary</div>
                            <div class="table-responsive">
                              <table class="table table-striped table-hover table-md">
                                <tr>
                                  <!-- <th data-width="40">Sl</th> -->
                                  <th>House Name</th>
                                  <th class="text-center">House Owner Name </th>
                                  <th class="text-center">House Owner Nmber</th>
                                  <th class="text-center">Area</th>
                                  <th class="text-center">House Type</th>
                                  <th class="text-center">Location</th>
                                  <th class="text-center">Booking Amount</th>
                                </tr>
                                <tr>
                              
                                  <td><?php echo $rowHouse['name'] ?></td>
                                  <td class="text-center"><?php echo $rowHouse['owner_name'] ?></td>
                                  <td class="text-center"><?php echo $rowHouse['owner_phone'] ?></td>
                                  <td class="text-center"><?php echo $rowHouse['area'] ?></td>
                                  <td class="text-center"><?php echo $rowHouse['house_type'] ?></td>
                                  <td class="text-center"><?php echo $rowHouse['location'] ?></td>
                                  <td class="text-center"><?php echo $row['amount'] ?>TK</td>
                                </tr>
                              </table>
                            </div>
                            <div class="row mt-4">
                              <div class="col-lg-8">
                                <div class="section-title"><b></b></div>
                                <p class="section-lead">Sweet Home Ltd.</p>
                                <div class="d-flex">
                                  <div class="mr-2 bg-visa" data-width="61" data-height="38"></div>
                                  <div class="mr-2 bg-jcb" data-width="61" data-height="38"></div>
                                  <div class="mr-2 bg-mastercard" data-width="61" data-height="38"></div>
                                  <div class="bg-paypal" data-width="61" data-height="38"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="text-md-right">
                        <button class="btn btn-warning btn-icon icon-left " onclick="window.print()"><i class="fas fa-print"></i> Print</button>
                      </div>
                    </div>
                  </div>
                </section>
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

  
  <script src="assets/js/main.js"></script>

</body>

</html>