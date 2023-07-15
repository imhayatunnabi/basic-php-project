<?php 
include 'session.php';
    include 'database/db.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booked'])){
            include 'database/db.php';

            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $amount = $_POST['amount'];
            $house_id = $_POST['house_id'];
            $customer_id = $_POST['customer_id'];
            $payment = $_POST['payment'];
            $txn_id = $_POST['txn_id'];
            $owner_name = $_POST['owner_name'];

            $query    = "INSERT INTO house_booked_list(name, phone, address, amount, house_id, customer_id, payment, txn_id, owner_name) VALUES(:name, :phone, :address, :amount, :house_id, :customer_id, :payment, :txn_id, :owner_name)";
                            
                $stmt     = $db->prepare($query);

                $stmt     -> bindValue(':name',$name,PDO::PARAM_STR);
                $stmt     -> bindValue(':phone',$phone,PDO::PARAM_STR);
                $stmt     -> bindValue(':address',$address,PDO::PARAM_STR);
                $stmt     -> bindValue(':amount',$amount,PDO::PARAM_STR);
                $stmt     -> bindValue(':house_id',$house_id,PDO::PARAM_STR);
                $stmt     -> bindValue(':customer_id',$customer_id,PDO::PARAM_STR);
                $stmt     -> bindValue(':payment',$payment,PDO::PARAM_STR);
                $stmt     -> bindValue(':txn_id',$txn_id,PDO::PARAM_STR);
                $stmt     -> bindValue(':owner_name',$owner_name,PDO::PARAM_STR);

                $result   = $stmt->execute();

                if ($result) {
                  $query              = "UPDATE house SET status=3 WHERE id=:id";
                  $stmt               = $db->prepare($query);
                  $stmt               -> bindValue(':id',$house_id, PDO::PARAM_STR);
                  $result             = $stmt->execute();

                    ?><script type="text/javascript">
                        alert('House booking successfull!');location.href = 'house.php';</script><?php

                }else{
                    ?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
                }
        }

        $id  = $_REQUEST['id'];


        $queryHouse   = "SELECT * FROM house WHERE id={$id}";
        $stmtHouse    = $db->prepare($queryHouse);
        $resultHouse  = $stmtHouse->execute();
        $rowHouse     = $stmtHouse->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sweet  Home</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">

 
</head>

<body>

  <?php include 'partials_header.php' ?>

  <!--/ Intro Single star /-->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single"><?php echo $rowHouse['name'] ?></h1>
            <span class="color-text-a"><?php echo $rowHouse['location'] ?></span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="index.php">Home</a>
              </li>
              <li class="breadcrumb-item">
                <a href="house.php">Properties</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                <?php echo $rowHouse['name'] ?>
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Property Single Star /-->
  <section class="property-single nav-arrow-b">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property">
            <?php 
               $photo = $rowHouse['photo'];

               $photoArray = explode(", ",$photo);

               $lenth = count($photoArray);

               for ($i=0; $i < $lenth  ; $i++) {?>
            <div class="carousel-item-b">
              <img src="hw_dashboard/assets/img/house-image/<?php echo $photoArray[$i++] ?>" alt="">
            </div>
            <?php } ?>
          </div>
          <div class="row justify-content-between">
            <div class="col-md-5 col-lg-4">
              <div class="property-price d-flex justify-content-center foo">
                <div class="">
                  <div class="">
                    <span class="ion-money">BDT</span>
                  </div>
                  <div class="card-title-c align-self-center">
                    <h5 class="title-c"><?php echo $rowHouse['price'] ?></h5>
                  </div>
                </div>
              </div>
              <div class="property-summary">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="title-box-d section-t4">
                      <h3 class="title-d">Quick Summary</h3>
                    </div>
                  </div>
                </div>
                <div class="summary-list">
                  <ul class="list">
                    <li class="d-flex justify-content-between">
                      <strong>Location:</strong>
                      <span><?php echo $rowHouse['location'] ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Property Type:</strong>
                      <span><?php echo $rowHouse['house_type'] ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Status:</strong>
                      <span><?php if($rowHouse['status'] == 2){
                          echo "<p class='bg-danger text-white px-3'>Booked</p>";
                      } elseif($rowHouse['status'] == 1){
                        echo "<p class='bg-success text-white px-3'>Available</p>";
                      } else {
                        echo "<p class='bg-warning text-white px-3'>Unavailable</p>";
                      } ?>
                      </span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Area:</strong>
                      <span><?php echo $rowHouse['area'] ?>fit
                        <sup>2</sup>
                      </span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Beds:</strong>
                      <span><?php echo $rowHouse['total_room'] ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Baths:</strong>
                      <span><?php echo $rowHouse['total_washroom'] ?></span>
                    </li>

                    <li class="d-flex justify-content-between">
                      <strong>House owner:</strong>
                      <span><?php echo $rowHouse['owner_name'] ?></span>
                    </li>

                    <li class="d-flex justify-content-between">
                      <strong>Phone:</strong>
                      <span><?php echo $rowHouse['owner_phone'] ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Rental From:</strong>
                      <span><?php 
                      if($rowHouse['status'] == 1){
                        echo $rowHouse['rent_from'];
                      }
                      ?></span>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-7 col-lg-7 section-md-t3">
              <div class="row">
                <div class="col-sm-12">
                  <div class="title-box-d">
                    <h3 class="title-d">Property Description</h3>
                  </div>
                </div>
              </div>
              <div class="property-description">
                <p class="description color-text-a">
                  <?php echo $rowHouse['description'] ?>
                </p>
              </div>
              <div class="row section-t3">
                <div class="col-sm-12">
                  <div class="title-box-d">
                    <h3 class="title-d">Amenities</h3>
                  </div>
                </div>
              </div>
              <div class="amenities-list color-text-a">
                <ul class="list-a no-margin">
                  <li>Balcony</li>
                  <li>Outdoor Kitchen</li>
                  <li>Deck</li>
                  <li>Tennis Courts</li>
                  <li>Parking</li>
                  <li>Sun Room</li>
                
                </ul>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="row section-t3">
            <div class="col-sm-12">
              <?php if(isset($_SESSION['customer_id'])){ ?>
                  <?php if($rowHouse['status'] == 1){ ?>
                  <button type="submit" class="btn btn-a" data-toggle="modal" data-target="#exampleModalCenter">Book Now</button>
                  <?php }elseif($rowHouse['status'] != 1){ ?>
                    <div class="bg-warning p-3 text-center">
                      This house is booked.
                    </div>
                  <?php } ?>
              <?php }else{ ?>
                <div class="bg-warning p-3 text-center">
                  To book a house, you need to login first.
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Property Single End /-->


  <!-- Modal -->
<form action="" method="POST">
    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="house_id" value="<?php echo $rowHouse['id'] ?>">
                    <input type="hidden" name="owner_name" value="<?php echo $rowHouse['owner_name'] ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id'] ?>">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" min=0 class="form-control" name="phone" id="phone" placeholder="Enter phone number" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Booking Amount</label>
                            <input type="number" min=10000 max = <?php echo $rowHouse['price'] ?> class="form-control" name="amount" id="amount" placeholder="Enter amount"required>
                        </div>
                    </div>

                    <div class="col-md-12 pt-3">
                       <p class="text-center text-primary"><strong>Bkash Number: 01828698246 (Minimum Amount 10000 tk)</strong></p>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment">Payment Method</label>
                            <select class="form-control" id="payment" name="payment">
                              <option value="Bkash">Bkash</option>
                              <option value="Nagad">Nagad</option>
                             
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txn_id">Transaction ID/Details</label>
                            <input type="text" class="form-control" name="txn_id" id="tnx id" placeholder="Enter txn id/details" required>
                        </div>
                    </div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="booked" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
</form>



  <!--/ footer Star /-->
  <?php include 'partials_footer.php' ?>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          
          <div class="socials-a">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-dribbble" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </div>
          <div class="copyright-footer">
            <p class="copyright color-text-a">
              &copy; Copyright
              <span class="color-a">Sweet Home</span> All Rights Reserved.
            </p>
          </div>
          <div class="credits">
            
            Designed by <a href="#">Sweet Home</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--/ Footer End /-->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/popper/popper.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/scrollreveal/scrollreveal.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>
</html>
