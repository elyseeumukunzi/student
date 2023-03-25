<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  // Code for deletion
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "delete from tblstudent where ID=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'manage-students.php'</script>";


  }

  ?><!--  Orginal Author Name: Mayuri.K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mdkhairnar92@gmail.com  
 Visit website : https://mayurik.com -->

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
          <h3 class="page-title"> Manage Student </h3>
          <div class="row">
            <div class="col-md-4" style="background:white; color:black">Exellent</div>
            <div class="col-md-4" style="background:skyblue; color:white">Good</div>
            <div class="col-md-4" style="background:red; color:white">Indiscipline</div>
          </div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Manage Students</li>
            </ol>
          </nav>
        </div>
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="d-sm-flex align-items-center mb-4">
                  <h4 class="card-title mb-sm-0">Filter your data</h4>
                </div>
                <div class="row">
                  <div class="col-md-2">
                    <form class="forms-sample" method="GET" Action="manage-students.php">
                      <div class="form-group">
                        <label for="exampleInputName1">Year</label>
                        <select name="year" class="form-control" required='true'>
                          <?php

                          $thisyear = date('Y');
                          $sql = "SELECT * FROM tblyears WHERE year=:thisyear";
                          $query = $dbh->prepare($sql);
                          $query->bindParam(':thisyear', $thisyear, PDO::PARAM_STR);
                          $query->execute();
                          $results = $query->fetchAll(PDO::FETCH_OBJ);
                          if ($query->rowCount() > 0) {
                            foreach ($results as $row) {

                              ?>
                              <option value="<?php echo htmlentities($row->id) ?>"><?php echo htmlentities($row->year) ?>
                              </option>
                            <?php }
                          } ?>
                        </select>
                      </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInputEmail3">Term</label>
                      <select name="term" value="" class="form-control" required='true'>
                        <?php
                        $thisyear = date('Y');
                        $sql = "SELECT tblterms.id,tblterms.term FROM tblterms,tblyears WHERE tblterms.yearid = tblyears.id AND tblyears.year =:thisyear ORDER BY tblterms.id DESC";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':thisyear', $thisyear, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $row) {
                            ?>
                            <option value="<?php echo $row->term; ?>">
                              <?php $term = htmlentities($row->term);
                              if ($term == 1) {
                                echo $term . "st Term";
                              } elseif ($term == 2) {
                                echo $term . "nd Term";
                              } elseif ($term == 3) {
                                echo $term . "rd Term";
                              } else {
                                echo "error";
                              }
                              ?>
                            </option>


                          <?php }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInputEmail3">Section</label>
                      <select name="level" class="form-control" required='true'>
                        <?php

                        $thisyear = date('Y');
                        $sql = "SELECT * FROM tbllevels";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                          foreach ($results as $row) {

                            ?>
                            <option value="<?php echo htmlentities($row->id) ?>"><?php echo htmlentities($row->levelname) ?>
                            </option>
                          <?php }
                        } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInputEmail3">Section</label>
                      <button class="btn btn-success" type="submit"><i class="icon-magnifier"></i></button>
                    </div>
                  </div>
                  </form>

                  <a href="manage-students.php" class="text-dark ml-auto mb-3 mb-sm-0"> View all Students</a>
                </div>
                <div class="table-responsive border rounded p-1">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="font-weight-bold">S.No</th>
                        <th class="font-weight-bold">Student ID</th>
                        <th class="font-weight-bold">Student Class</th>
                        <th class="font-weight-bold">Student Name</th>
                        <!-- <th class="font-weight-bold">Student Email</th> -->
                        <th class="font-weight-bold">Conduct</th>
                        <th class="font-weight-bold">Action</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                      } else {
                        $pageno = 1;
                      }
                      // Formula for pagination
                      $no_of_records_per_page = 15;
                      $offset = ($pageno - 1) * $no_of_records_per_page;
                      $ret = "SELECT ID FROM tblstudent";
                      $query1 = $dbh->prepare($ret);
                      $query1->execute();
                      $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                      $total_rows = $query1->rowCount();
                      $total_pages = ceil($total_rows / $no_of_records_per_page);
                      $year = $_GET['year'];
                      $term = $_GET['term'];
                      $level = $_GET['level'];
                      $sql = "SELECT tblstudent.ID,tblstudent.StudentName,tblstudent.DateofAdmission,tblstudent.StuID,tbllevels.levelname,tblclass.ClassName,tblsconducts.marks,tblclass.Section,tblterms.id FROM tblstudent,tbllevels,tblclass,tblsconducts,tblyears,tblterms WHERE tblterms.yearid=tblyears.id AND tblsconducts.termid=tblterms.id AND tblstudent.StudentClass = tblclass.ID AND tblclass.LevelId = tbllevels.id AND tblsconducts.studentid = tblstudent.ID AND tblyears.id=:year AND tblterms.term=:term AND tbllevels.id=:level LIMIT $offset, $no_of_records_per_page";
                      $query = $dbh->prepare($sql);
                      $query->bindParam(':year', $year, PDO::PARAM_STR);
                      $query->bindParam(':term', $term, PDO::PARAM_STR);
                      $query->bindParam(':level', $level, PDO::PARAM_STR);
                      $query->execute();
                      $results = $query->fetchAll(PDO::FETCH_OBJ);
                      $cnt = 1;


                      if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                          <tr>

                            <td>
                              <?php echo htmlentities($cnt); ?>
                            </td>
                            <td>
                              <?php echo htmlentities($row->StuID); ?>
                            </td>
                            <td>
                              <?php echo htmlentities($row->ClassName); ?>
                              <?php echo htmlentities($row->Section); ?>
                              <?php echo htmlentities($row->levelname); ?>
                            </td>
                            <td>
                              <?php echo htmlentities($row->StudentName); ?>
                            </td>

                            <?php
                            if (htmlentities($row->marks) <= 49) {
                              ?>
                              <td style="background:red; color:white">
                                <?php echo htmlentities($row->marks); ?>
                              </td>
                              <?php
                            } elseif (htmlentities($row->marks) <= 69) {
                              ?>
                              <td style="background:skyblue; color:white">

                                <?php echo htmlentities($row->marks); ?>
                              </td>
                              <?php
                            } elseif (htmlentities($row->marks) >= 70) {
                              ?>
                              <td>
                                <?php echo htmlentities($row->marks);
                            } ?>
                            </td>
                            <td>
                              <a href="tostudent.php?studentid=<?php echo htmlentities($row->ID) ?>&showterm=<?php echo $row->id; ?>"
                                class="btn btn-primary btn-sm"><i class="icon-drawer"></i></a>
                              <a href="edit-student-detail.php?editid=<?php echo htmlentities($row->ID); ?>"
                                class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                              <a href="manage-students.php?delid=<?php echo ($row->ID); ?>"
                                onclick="return confirm('Do you really want to Delete ?');" class="btn btn-danger btn-sm">
                                <i class="icon-trash"></i></a>
                            </td>
                          </tr>
                          <?php $cnt = $cnt + 1;
                        }
                      } elseif (!isset($_GET['level'])) {
                        $sql = "SELECT tblstudent.ID,tblstudent.StudentName,tblstudent.DateofAdmission,tblstudent.StuID,tbllevels.levelname,tblclass.ClassName,tblsconducts.marks,tblclass.Section,tblterms.id FROM tblstudent,tbllevels,tblclass,tblsconducts,tblyears,tblterms WHERE tblterms.yearid=tblyears.id AND tblsconducts.termid=tblterms.id AND tblstudent.StudentClass = tblclass.ID AND tblclass.LevelId = tbllevels.id AND tblsconducts.studentid = tblstudent.ID LIMIT $offset, $no_of_records_per_page";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results as $row) {
                             ?>
                            <tr>

                              <td>
                                <?php echo htmlentities($cnt); ?>
                              </td>
                              <td>
                                <?php echo htmlentities($row->StuID); ?>
                              </td>
                              <td>
                                <?php echo htmlentities($row->ClassName); ?>
                                <?php echo htmlentities($row->Section); ?>
                                <?php echo htmlentities($row->levelname); ?>
                              </td>
                              <td>
                                <?php echo htmlentities($row->StudentName); ?>
                              </td>                              
                                <?php
                                if (htmlentities($row->marks) <= 49) {
                                  ?>
                                <td style="background:red; color:white">
                                  <?php echo htmlentities($row->marks); ?>
                                </td>
                                <?php
                                } elseif (htmlentities($row->marks) <= 69) {
                                  ?>
                                <td style="background:skyblue; color:white">

                                  <?php echo htmlentities($row->marks); ?>
                                </td>
                                <?php
                                } elseif (htmlentities($row->marks) >= 70) {
                                  ?>
                                <td>

                                  <?php echo htmlentities($row->marks); ?>
                                  <?php 
                                } ?>
                              </td>
                                                          
                              <td>
                                <!--remember to send the term id by default to sign conducts-->
                                <a href="tostudent.php?studentid=<?php echo htmlentities($row->ID) ?>&showterm=<?php echo $row->id; ?>"
                                  class="btn btn-primary btn-sm"><i class="icon-drawer"></i></a>
                                <a href="edit-student-detail.php?editid=<?php echo htmlentities($row->ID); ?>"
                                  class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                <a href="manage-students.php?delid=<?php echo ($row->ID); ?>"
                                  onclick="return confirm('Do you really want to Delete ?');" class="btn btn-danger btn-sm">
                                  <i class="icon-trash"></i></a>
                              </td>
                            </tr>
                            <?php $cnt = $cnt + 1;
                          }
                        }

                      }


                      ?>
                    </tbody>
                  </table>
                </div>
                <div align="left">
                  <ul class="pagination">
                    <li><a href="?pageno=1"><strong>First></strong></a></li>
                    <li class="<?php if ($pageno <= 1) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno <= 1) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno - 1);
                      } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                    </li>
                    <li class="<?php if ($pageno >= $total_pages) {
                      echo 'disabled';
                    } ?>">
                      <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
                      } else {
                        echo "?pageno=" . ($pageno + 1);
                      } ?>"><strong style="padding-left: 10px">Next></strong></a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends --><!--  Orginal Author Name: Mayuri.K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mdkhairnar92@gmail.com  
 Visit website : https://mayurik.com -->
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