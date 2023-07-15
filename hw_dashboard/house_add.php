<?php 
  include '../session.php';

  if (!isset($_SESSION['house_owner_id'])) {
            header('location: ../login.php');
    } else{

      include '../database/db.php';

      include '../database/db.php';

      $query              = "SELECT * FROM location";
      $stmt               = $db->prepare($query);
      $result             = $stmt->execute();

      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){

        include '../database/db.php';

        $name = $_POST['name'];
        $total_room = $_POST['total_room'];
        $total_washroom = $_POST['total_washroom'];
        $area = $_POST['area'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $owner_name = $_SESSION['house_owner_name'];
        $owner_phone = $_POST['owner_phone'];
        $location = $_POST['location'];
        $house_type = $_POST['house_type'];
        $purpose = $_POST['purpose'];
        $reference_id = $_POST['reference_id'];
        $rent_from = $_POST['rent_from'];        
        


        $target_dir = "assets/img/house-image/";
        $allowedFileType = array('jpg','png','jpeg');
        $sqlVal = '';


        // Velidate if files exist
        if (!empty(array_filter($_FILES['photo']['name']))) {
            
            // Loop through file items
            foreach($_FILES['photo']['name'] as $id=>$val){
                // Get files upload path

                $photo        = $_FILES['photo']['name'][$id];
                $tmp_photo    = $_FILES['photo']['tmp_name'][$id];


                $target_file  = $target_dir . basename($photo);

                $target_file = bin2hex(random_bytes(8));
                $target_file = hash_hmac('sha256', $target_file, 'houserent');

                $fileType        = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $uploadDate      = date('Y-m-d H:i:s');
                $uploadOk = 1;
                $extension      = 'jpg';
                $newfilename    = $target_file .".".$extension;

                if(move_uploaded_file($tmp_photo, $target_dir.$newfilename)){
                    if(empty($sqlVal)){
                      $sqlVal = $newfilename;
                    } else{
                      $sqlVal = $sqlVal.', '.$newfilename;
                    }
                    
                }
            }
        }


        //insert into database
        $query    = "INSERT INTO house(name, total_room, total_washroom,area,price, description, owner_name, owner_phone, location, house_type, purpose, reference_id, rent_from, photo) 
                VALUES(:name, :total_room, :total_washroom,:area,:price, :description, :owner_name, :owner_phone, :location, :house_type, :purpose, :reference_id, :rent_from, :photo)";
                
        $stmt     = $db->prepare($query);

          $stmt     -> bindValue(':name',$name,PDO::PARAM_STR);
          $stmt     -> bindValue(':total_room',$total_room,PDO::PARAM_STR);
          $stmt     -> bindValue(':total_washroom',$total_washroom,PDO::PARAM_STR);
          $stmt     -> bindValue(':area',$area,PDO::PARAM_STR);
          $stmt     -> bindValue(':price',$price,PDO::PARAM_STR);
          $stmt     -> bindValue(':description',$description,PDO::PARAM_STR);
          $stmt     -> bindValue(':owner_name',$owner_name,PDO::PARAM_STR);
          $stmt     -> bindValue(':owner_phone',$owner_phone,PDO::PARAM_STR);
          $stmt     -> bindValue(':location',$location,PDO::PARAM_STR);
          $stmt     -> bindValue(':house_type',$house_type,PDO::PARAM_STR);
          $stmt     -> bindValue(':purpose',$purpose,PDO::PARAM_STR);
          $stmt     -> bindValue(':reference_id',$reference_id,PDO::PARAM_STR);
          $stmt     -> bindValue(':rent_from',$rent_from,PDO::PARAM_STR);
          $stmt     -> bindValue(':photo',$sqlVal,PDO::PARAM_STR);

        $result   = $stmt->execute();

        if ($result) {
          ?><script type="text/javascript">alert("House Added successfully."); location.href = 'house.php';</script><?php
        }else{
          ?><script type="text/javascript">alert("Oops! something went wrong.");</script><?php
        }

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
          <li class="breadcrumb-item active">House Add</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

      
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add House</h5>

              <form action="house_add.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                
                <div class="col-md-12">
                  <label for="name" class="form-label">House Name</label>
                  <input type="text" class="form-control" name="name" id="name"  placeholder="Enter Name"required>
                  <div class="invalid-feedback">
                    Please provide a name.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="total_room" class="form-label">Total Room</label>
                  <input type="number" min=0 class="form-control" name="total_room" id="total_room" placeholder="Enter Room" required>
                  <div class="invalid-feedback">
                    Please provide a total room.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="total_washroom" class="form-label">Total Washroom</label>
                  <input type="number" min=0 class="form-control" name="total_washroom" id="total_washroom" placeholder="Enter Washroom" required>
                  <div class="invalid-feedback">
                    Please provide a total washroom.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="area" class="form-label"> Area</label>
                  <input type="number" min=0 class="form-control" name="area" id="area"  placeholder="Enter Area" required>
                  <div class="invalid-feedback">
                    Please provide a area.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" min=0 class="form-control" name="price" id="price" placeholder="Enter Price" required>
                  <div class="invalid-feedback">
                    Please provide a price.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="owner_phone" class="form-label">Phone</label>
                  <input type="number" min=0 class="form-control" name="owner_phone" id="owner_phone" placeholder="Enter Number" required>
                  <div class="invalid-feedback">
                    Please provide a phone.
                  </div>
                </div>


                <div class="col-md-6">
                  <label for="location" class="form-label"> Location</label>
                  <select class="form-select" name="location" id="location" required>
                    <option selected disabled value="">Choose location</option>
                    <?php 
                      $i = 1;
                      while($row  = $stmt->fetch()){?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                  </select>
                  <div class="invalid-feedback">
                    Please select a location.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="house_type" class="form-label">House Type</label>
                  <select class="form-select" name="house_type" id="house_type" required>
                    <option selected disabled value="">Choose type</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Residential">Residential</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a type.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="purpose" class="form-label">Purpose</label>
                  <select class="form-select" name="purpose" id="purpose" required>
                    <option value="For Rent">For Rent</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a purpose.
                  </div>
                </div>



                <div class="col-md-6">
                  <label for="reference_id" class="form-label">Reference no.</label>
                  <input type="text" class="form-control" name="reference_id" id="reference_id"  placeholder="Enter Ref.no" required>
                  <div class="invalid-feedback">
                    Please provide a reference no.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="rent_from" class="form-label">Rental From</label>
                  <input type="date" class="form-control" name="rent_from" id="rent_from" required>
                  <div class="invalid-feedback">
                    Please provide a rent from.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="description" class="form-label"> House Address Discription</label>
                  <textarea class="form-control" name="description" id="description" required></textarea>
                  <div class="invalid-feedback">
                    Please provide a Adress.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="photo" class="form-label">House Photo</label>
                  <input type="file" class="form-control" name="photo[]" id="photo" required multiple>
                  <div class="invalid-feedback">
                    Please provide a photo.
                  </div>
                </div>


                <div class="col-12">
                  <button class="btn btn-primary" type="submit" name="add">Add</button>
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

  <!--  Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="../js/jquery.min.js"></script>

  <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        // today = mm + '-' + yyyy + '-' + dd;
        $('#rent_from').attr('min',today);
  </script>

</body>

</html>