<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $stuname = $_POST['stuname'];
    $stuemail = $_POST['stuemail'];
    $stuclass = $_POST['stuclass'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $stuidd = $_POST['stuid'];
    $stuid = "APD/" . $stuidd;
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $connum = $_POST['connum'];
    $altconnum = $_POST['altconnum'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $password = md5($_POST['password']);
    $image = $_FILES["image"]["name"];
    $status = 1;
    $ret = "select UserName from tblstudent where UserName=:uname || StuID=:stuid";
    $query = $dbh->prepare($ret);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() == 0) {
      $extension = substr($image, strlen($image) - 4, strlen($image));
      $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif", ".JPG", ".JPEG", ".PNG", ".GIF", "");
      if (!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Logo has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
      } else {
        $image = md5($image) . time() . $extension;
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $image);
        $sql = "insert into tblstudent(StudentName,StudentEmail,StudentClass,Gender,DOB,StuID,FatherName,MotherName,ContactNumber,AltenateNumber,Address,UserName,Password,Image,status)values(:stuname,:stuemail,:stuclass,:gender,:dob,:stuid,:fname,:mname,:connum,:altconnum,:address,:uname,:password,:image,:status )";
        $query = $dbh->prepare($sql);
        $query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
        $query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
        $query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':mname', $mname, PDO::PARAM_STR);
        $query->bindParam(':connum', $connum, PDO::PARAM_STR);
        $query->bindParam(':altconnum', $altconnum, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':uname', $uname, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        $studentid = $LastInsertId;
        $termid = $_POST['term'];
        if ($LastInsertId > 0) {
          $marks = 100;
          $addconducts = "insert into tblsconducts(marks,termid,studentid)values(:marks,:termid,:studentid)";
          $query2 = $dbh->prepare($addconducts);
          $query2->bindParam(':marks', $marks, PDO::PARAM_STR);
          $query2->bindParam(':termid', $termid, PDO::PARAM_STR);
          $query2->bindParam(':studentid', $studentid, PDO::PARAM_STR);
          $query2->execute();
          echo '<script>alert("Student has been added.")</script>';
          echo "<script>window.location.href ='add-students.php'</script>";
        } else {
          echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
      }
    } else {

      echo "<script>alert('Username or Student Id  already exist. Please try again');</script>";
    }
  }
  ?>
  <!--  Orginal Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->
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
          <h3 class="page-title"> Add Students </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Add Students</li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">


                <form class="forms-sample row" method="post" enctype="multipart/form-data">

                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Student Name</label>
                    <input type="text" name="stuname" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Student Email</label>
                    <input type="text" name="stuemail" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputEmail3">Student Class</label>
                    <select name="stuclass" class="form-control" required='true'>
                      <option value="">Select Class</option>
                      <?php

                      $sql2 = "SELECT * from    tblclass,tbllevels WHERE tblclass.LevelId = tbllevels.id";
                      $query2 = $dbh->prepare($sql2);
                      $query2->execute();
                      $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                      foreach ($result2 as $row1) {
                        ?>
                        <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->ClassName) ?>
                          <?php echo htmlentities($row1->Section) . "  " . htmlentities($row1->levelname); ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Gender</label>
                    <select name="gender" value="" class="form-control" required='true'>
                      <option value="">Choose Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Date of Birth</label>
                    <input type="date" name="dob" value="" class="form-control" required='true'>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Student ID</label>
                    <div class="row">
                      <div class="col-md-2 sm-6">
                        <p><b>APD/</b></p>
                      </div>
                      <div class="col-md-8 sm-6">
                        <input type="text" name="stuid" value="" class="form-control" required='true'>
                      </div>


                    </div>

                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Student Photo</label>
                    <input type="file" name="image" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Admittion term <i>* this year</i></label>
                    <select name="term" value="" class="form-control" required='true'>
                      <?php
                      $thisyear = date('Y');
                      $sql = "SELECT tblterms.id,tblterms.term,tblyears.year FROM tblterms,tblyears WHERE tblterms.yearid = tblyears.id AND tblyears.year =:thisyear ORDER BY tblterms.id DESC";
                      $query = $dbh->prepare($sql);
                      $query->bindParam(':thisyear', $thisyear, PDO::PARAM_STR);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                          ?>
                          <option value="<?php echo $row->id ?>"> 
                          <?php $term = htmlentities($row->term);
                             if ($term == 1) {
                               echo $row->year." ". $term . "st Term";
                             }
                             elseif ($term == 2) {
                              echo $row->year." ".$term . "nd Term";
                             }
                             elseif ($term == 3) {
                              echo $row->year." ".$term . "rd Term";
                             }
                             else
                             {
                              echo "error";
                             }
                              ?>
                             </option>


                        <?php }
                      } else {
                        ?>
                        <option>No term yet</option>

                        <?php
                      }
                      ?>
                    </select>
                  </div>
                  <h3 class="col-md-12">Parents/Guardian's details</h3>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Father's Name</label>
                    <input type="text" name="fname" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Mother's Name</label>
                    <input type="text" name="mname" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Contact Number</label>
                    <input type="text" name="connum" value="" class="form-control" required='true' maxlength="10"
                      pattern="[0-9]+">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Alternate Contact Number</label>
                    <input type="text" name="altconnum" value="" class="form-control" required='true' maxlength="10"
                      pattern="[0-9]+">
                  </div>
                  <div class="form-group col-md-12">
                    <label for="exampleInputName1">Address</label>
                    <textarea name="address" class="form-control"></textarea>
                  </div>
                  <h3 class="col-md-12">Login details</h3>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">User Name</label>
                    <input type="text" name="uname" value="" class="form-control" required='true'>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="exampleInputName1">Password</label>
                    <input type="Password" name="password" value="" class="form-control" required='true'>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>

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
<?php } ?>