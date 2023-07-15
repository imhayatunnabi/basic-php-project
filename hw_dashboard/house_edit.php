<?php 
  include '../session.php';

  if (!isset($_SESSION['house_owner_id'])) {
            header('location: ../login.php');
    } else{

        if(!isset($_REQUEST['id'])){
            header('location: house.php');
        }

        include '../database/db.php';

        $id  = $_REQUEST['id'];

        //edit into database
        $query              = "SELECT * FROM house WHERE id=:id";
        $stmt               = $db->prepare($query);
        $stmt               -> bindValue(':id',$id, PDO::PARAM_STR);
        $result             = $stmt->execute();
        $row                = $stmt->fetch();


        $queryLocation     = "SELECT * FROM location";
        $stmtLocation      = $db->prepare($queryLocation);
        $resultLocation    = $stmtLocation->execute();

        
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){

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
        } else{

          $queryPhoto  = "SELECT * FROM house WHERE id=:id";
          $stmtPhoto        = $db->prepare($queryPhoto);
          $stmtPhoto        -> bindValue(':id',$id, PDO::PARAM_STR);
          $resultPhoto      = $stmtPhoto->execute();
          $rowPhoto         = $stmtPhoto->fetch();

          $sqlVal=$rowPhoto['photo'];
        }


        //insert into database
        $query    = "UPDATE house SET name=:name, total_room=:total_room, total_washroom=:total_washroom, area=:area, price=:price, description=:description, owner_name=:owner_name, owner_phone=:owner_phone, location=:location, house_type=:house_type, purpose=:purpose, reference_id=:reference_id, rent_from=:rent_from, photo=:photo WHERE id = :id";
                
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
          $stmt     -> bindValue(':id',$id, PDO::PARAM_STR);


        $result   = $stmt->execute();

        if ($result) {
          ?><script type="text/javascript">alert("House Edited successfully."); location.href = 'house.php';</script><?php
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
          <li class="breadcrumb-item active">House Edit</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">

            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit House</h5>

              <form action="house_edit.php" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                <input name='id' type='hidden' value="<?php echo $id;?>">
                
                <div class="col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" id="name" required value="<?php echo $row['name']; ?>">
                  <div class="invalid-feedback">
                    Please provide a name.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="total_room" class="form-label">Total Room</label>
                  <input type="number" class="form-control" name="total_room" id="total_room" required value="<?php echo $row['total_room']; ?>">
                  <div class="invalid-feedback">
                    Please provide a total room.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="total_washroom" class="form-label">Total Washroom</label>
                  <input type="number" class="form-control" name="total_washroom" id="total_washroom" required value="<?php echo $row['total_washroom']; ?>">
                  <div class="invalid-feedback">
                    Please provide a total washroom.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="area" class="form-label">Area</label>
                  <input type="number" class="form-control" name="area" id="area" required value="<?php echo $row['area']; ?>">
                  <div class="invalid-feedback">
                    Please provide a area.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" class="form-control" name="price" id="price" required value="<?php echo $row['price']; ?>">
                  <div class="invalid-feedback">
                    Please provide a price.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="owner_phone" class="form-label">Phone</label>
                  <input type="text" class="form-control" name="owner_phone" id="owner_phone" required value="<?php echo $row['owner_phone']; ?>">
                  <div class="invalid-feedback">
                    Please provide a phone.
                  </div>
                </div>


                <div class="col-md-6">
                  <label for="location" class="form-label">Location</label>
                  <select class="form-select" name="location" id="location" required>
                    <?php 
                      $i = 1;

                      while($rowLocation  = $stmtLocation->fetch()){?>
                    <option value="<?php echo $rowLocation['name']; ?>"  <?php if($rowLocation['name']==$row['location']) echo "selected" ?>><?php echo $rowLocation['name']; ?></option>
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
                    <option value="Commercial" <?php if($row['house_type']=="Commercial") echo "selected" ?>>Commercial</option>
                    <option value="Residential" <?php if($row['house_type']=="Residential") echo "selected" ?>>Residential</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a type.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="purpose" class="form-label">Purpose</label>
                  <select class="form-select" name="purpose" id="purpose" required value="<?php echo $row['purpose']; ?>">
                    <option value="Commercial">For Rent</option>
                  </select>
                  <div class="invalid-feedback">
                    Please select a purpose.
                  </div>
                </div>



                <div class="col-md-6">
                  <label for="reference_id" class="form-label">Reference no.</label>
                  <input type="text" class="form-control" name="reference_id" id="reference_id" required value="<?php echo $row['reference_id']; ?>">
                  <div class="invalid-feedback">
                    Please provide a reference no.
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="rent_from" class="form-label">Rent From</label>
                  <input type="date" class="form-control" name="rent_from" id="rent_from" required value="<?php echo $row['rent_from']; ?>">
                  <div class="invalid-feedback">
                    Please provide a rent from.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" name="description" id="description" required><?php echo $row['description']; ?></textarea>
                  <div class="invalid-feedback">
                    Please provide a description.
                  </div>
                </div>

                <div class="col-md-12">
                  <label for="photo" class="form-label">Photo</label>
                  <input type="file" class="form-control" name="photo[]" id="photo" multiple>
                </div>


                <div class="col-12">
                  <button class="btn btn-primary" type="submit" name="edit">Edit</button>
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

</body>

</html>