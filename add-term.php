<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['saveyear'])) {
    $year = $_POST['year'];
    $description = $_POST['description'];
    $selectcurrent = "SELECT id FROM tblyears WHERE year=:year";
    $query = $dbh->prepare($selectcurrent);
    $query->bindParam(':year', $year, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      echo '<script>alert("This year exist already")</script>';

    } else {
      $sql = "insert into tblyears(year,description)values(:year,:description)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':year', $year, PDO::PARAM_STR);
      $query->bindParam(':description', $description, PDO::PARAM_STR);

      $query->execute();
      $LastInsertId = $dbh->lastInsertId();
      if ($LastInsertId > 0) {
        echo '<script>alert("new academic year has been added.")</script>';
        echo "<script>window.location.href ='add-term.php'</script>";
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }
    }
  }

  if (isset($_POST['saveterm'])) {
    $year = $_POST['year'];
    $term = $_POST['term'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $selectcurrent = "SELECT id FROM tblterms WHERE yearid=:year AND term=:term";
    $query = $dbh->prepare($selectcurrent);
    $query->bindParam(':year', $year, PDO::PARAM_STR);
    $query->bindParam(':term', $term, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
      echo '<script>alert("This term already exist")</script>';

    } else {
      $sql = "insert into tblterms(term,fromdates,todates,yearid)values(:term,:fromdate,:todate,:year)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':term', $term, PDO::PARAM_STR);
      $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
      $query->bindParam(':todate', $todate, PDO::PARAM_STR);
      $query->bindParam(':year', $year, PDO::PARAM_STR);
      $query->execute();
      $LastInsertId = $dbh->lastInsertId();
      $termid=$LastInsertId;
      
      if ($LastInsertId > 0) {
        $students = "SELECT ID FROM tblstudent";
        $query = $dbh->prepare($students);
        $query->execute();
        $results2 = $query->fetchAll(PDO::FETCH_OBJ);
                    
          foreach($results2 as $row) {
            echo $termid;            
            $studentid =$row->ID;           
            $marks = 100;
            $addconducts = "insert into tblsconducts(marks,termid,studentid)values(:marks,:termid,:studentid)";            
            $query2 = $dbh->prepare($addconducts);
            $query2->bindParam(':marks', $marks, PDO::PARAM_STR);
            $query2->bindParam(':termid', $termid, PDO::PARAM_STR);
            $query2->bindParam(':studentid', $studentid, PDO::PARAM_STR);
            $query2->execute();
            
          }
          if($query2 == 1)
          {
            echo '<script>alert("oops something went wrong.")</script>';
          }
          else
          {
            // echo '<script>alert("new term have been added.")</script>';
          }
            // echo '<script>alert("new term have been added.")</script>';
            // echo "<script>window.location.href ='add-term.php'</script>";
          
        
      } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
      }
    }

  }
  ?>
  <!-- partial:partials/_navbar.html -->
  <?php include_once('includes/header.php'); ?>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
      
          <h3 class="page-title">Create new term </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create new term</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Available academic years</h4>
                <div class="row ">
                  <?php
                  $sql = "SELECT * FROM tblyears";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) {

                      ?>
                      <div class=" col-md-3 report-inner-cards-wrapper">
                        <div class="report-inner-card color-1">
                          <div class="inner-card-text text-white">

                            <h4>
                              <?php echo htmlentities($row->year); ?>
                            </h4>
                            <a href="manage-class.php"><span class="report-count">
                                students</span></a>
                          </div>

                        </div>
                      </div>
                    <?php }
                  } ?>
                </div>

                <form class="forms-sample" method="POST" action="add-term.php">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="exampleInputName1">New year:</label>
                      <select name="year" class="form-control" required='true'>
                        <option value="">academic year</option>
                        <?php
                        $today = date('Y');
                        $nextyears = $today + 3;
                        for ($i = $today; $i <= $nextyears; $i++) {
                          ?>
                          <option value=" <?php echo htmlentities($i); ?>">
                            <?php echo htmlentities($i); ?>
                          </option>


                        <?php }
                        ?>
                      </select>

                    </div>

                    <div class="form-group col-md-4">
                      <label for="exampleInputName1">Description:</label>
                      <input type="text" class="form-control" id="description" name="description" value=""
                        required='true'>

                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary mr-2" name="saveyear">Save <span class=""></span></button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content-wrapper">

        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Create new term in a specific year</h4>

                <form class="forms-sample" method="post" action="add-term.php">

                  <div class="form-group">
                    <label for="exampleInputName1">Choose year:</label>
                    <select name="year" class="form-control" required='true'>
                      <option value="">Select year</option>
                      <?php
                      $sql = "SELECT * FROM tblyears";
                      $query = $dbh->prepare($sql);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt = 1;
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) {

                          ?>
                          <option value="<?php echo htmlentities($row->id) ?>"><?php echo htmlentities($row->year) ?></option>
                        <?php }
                      } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">Choose term:</label>
                    <select name="term" class="form-control" required='true'>
                      <option value="">Choose term</option>
                      <option value="1">1st Term</option>
                      <option value="2">2nd Term</option>
                      <option value="3">3rd Term</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">From Date:</label>
                    <input type="date" class="form-control" id="fromdate" name="fromdate" value="" required='true'>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputName1">To Date:</label>
                    <input type="date" class="form-control" id="todate" name="todate" value="" required='true'>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2" name="saveterm">Submit</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <?php include_once('includes/footer.php'); ?>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
<?php } ?>