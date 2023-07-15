<div class="click-closed"></div>
  <!--/ Form Search Star /-->
  <div class="box-collapse">
    <div class="title-box-d">
      <h3 class="title-d">Search Property</h3>
    </div>
    <span class="close-box-collapse right-boxed ion-ios-close"></span>
    <div class="box-collapse-wrap form">
      <form class="form-a" action="house.php" method="POST">
        <div class="row">
          
          
          <div class="col-md-12 mb-6">
            <label for="city">Location</label>
              <select class="form-control form-control-lg form-control-a" name="location" id="city">
                <?php 
                $queryLocation   = "SELECT * FROM location";
                $stmtLocation    = $db->prepare($queryLocation);
                $resultLocation  = $stmtLocation->execute();
                while ($rowLocation  = $stmtLocation->fetch()) {?>
                  <option value="<?php echo $rowLocation['name'] ?>"><?php echo $rowLocation['name'] ?></option>
                <?php } ?>
                
              </select>
            </div>
          </div>
          
          <div class="col-md-12">
            <button type="submit" name="search" class="btn btn-b">Search Property</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--/ Form Search End /-->

  <!--/ Nav Star /-->
  <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
        aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a class="navbar-brand text-brand" href="index.php">Sweet<span class="color-b"> Home</span></a>
      <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse"
        data-target="#navbarTogglerDemo01" aria-expanded="false">
        <span class="fa fa-search" aria-hidden="true"></span>
      </button>
      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="house.php">Property</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="house_owner.php">Agents</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
          <li class="nav-item">
              <!-- <div class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 10px;border: 1px solid #2eca6a;">Login Section</a>
                  <div class="dropdown-menu dropdown-menu-right">
                      <a href="admin_login.php" class="dropdown-item">Admin</a>
                      <a href="login.php" class="dropdown-item">House Owner</a>
                      <a href="customer_login.php" class="dropdown-item">Customer</a>
                  </div>
                </div> -->
          </li>
          
        </ul>
      </div>
      <button type="button" class="btn btn-b-n navbar-toggle-box-collapse d-none d-md-block" data-toggle="collapse"
        data-target="#navbarTogglerDemo01" aria-expanded="false">
        <span class="fa fa-search" aria-hidden="true"></span>
      </button>
    </div>
  </nav>
  <!--/ Nav End /-->