<?php 
  include 'session.php';
    include 'database/db.php';

    if(isset($_POST['search'])){
        $location = $_POST['location'];

        $query   = "SELECT * FROM house WHERE location='{$location}'";
        $stmt    = $db->prepare($query);
        $result  = $stmt->execute();

    }elseif(isset($_REQUEST['house_type'])){
        $house_type = $_REQUEST['house_type'];

        $query   = "SELECT * FROM house WHERE house_type='{$house_type}'";
        $stmt    = $db->prepare($query);
        $result  = $stmt->execute();
    } else{
        $query   = "SELECT * FROM house";
        $stmt    = $db->prepare($query);
        $result  = $stmt->execute();
    }

    $queryLocation   = "SELECT * FROM location";
    $stmtLocation    = $db->prepare($queryLocation);
    $resultLocation  = $stmtLocation->execute();
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
            <h1 class="title-single">Our Amazing Properties</h1>
            <span class="color-text-a">Properties</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="index.php">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
              <a href="house.php">Properties </a> 
               <!-- Properties  -->
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--/ Intro Single End /-->

  <!--/ Property Grid Star /-->
  <section class="property-grid grid">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="grid-option">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 10px;border: 1px solid #2eca6a;">House short by</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="house.php?house_type=Residential" class="dropdown-item">Residential</a>
                    <a href="house.php?house_type=Commercial" class="dropdown-item">Commercial</a>
                </div>
            </div>
          </div>
        </div>
        <?php while( $row = $stmt->fetch()){ 
          $photo = $row['photo'];

            $photo = explode(", ",$photo);
            $photo = $photo[0];
            $queryHouse   = "SELECT * FROM house WHERE id={$row['id']}";
        $stmtHouse    = $db->prepare($queryHouse);
        $resultHouse  = $stmtHouse->execute();
        $rowHouse     = $stmtHouse->fetch();
          ?>
        <div class="col-md-4">
          <div class="card-box-a card-shadow">
            <div class="img-box-a">
              <img src="hw_dashboard/assets/img/house-image/<?php echo $photo ?>" alt="" class="img-a img-fluid" height="400px">
            </div>
            <div class="card-overlay">
              <div class="card-overlay-a-content">
                <div class="card-header-a">
                  <h2 class="card-title-a">
                 
                    <a href="house_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                    
                  </h2>
                  <span><?php if($rowHouse['status'] == 2){
                          echo "<p style='width:6rem' class='text-danger bg-light px-3'>Booked</p>";
                      } elseif($rowHouse['status'] == 1){
                        echo "<p style='width:7rem' class='text-info bg-light px-3'>Available</p>";
                      } else {
                        echo "<p style='width:8rem' class='text-warning bg-light px-3'>Unavailable</p>";
                      } ?>
                      </span>
                </div>
                <div class="card-body-a">
                  <div class="price-box d-flex">
                    <span class="price-a">rent | BDT <?php echo $row['price']; ?></span>
                  </div>
                  <a href="house_details.php?id=<?php echo $row['id']; ?>" class="link-a">Click here to view
                    <span class="ion-ios-arrow-forward"></span>
                  </a>
                </div>
                <div class="card-footer-a">
                  <ul class="card-info d-flex justify-content-around">
                    <li>
                      <h4 class="card-info-title">Area</h4>
                      <span><?php echo $row['area']; ?>fit
                        <sup>2</sup>
                      </span>
                    </li>
                    <li>
                      <h4 class="card-info-title">Beds</h4>
                      <span><?php echo $row['total_room'] ?></span>
                    </li>
                    <li>
                      <h4 class="card-info-title">Baths</h4>
                      <span><?php echo $row['total_washroom'] ?></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </section>
  <!--/ Property Grid End /-->

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
            
            Designed by <a href="index.php">RAFTI</a>
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
