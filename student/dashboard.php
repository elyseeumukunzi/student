<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   
  ?>

      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto">Updated Report</span> <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row ">
                      <div class=" col-md-6 report-inner-cards-wrapper">
                        <div class="report-inner-card color-1">
                        <div class="inner-card-text text-white">
                           <?php 
                        $sql1 ="SELECT * from  tblclass";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$totclass=$query1->rowCount();
?>
                          <span class="report-title">Total Class</span>
                          <h4><?php echo htmlentities($totclass);?></h4>
                          <a href="manage-class.php"><span class="report-count"> View Classes</span></a>
                        </div>
                        <div class="inner-card-icon">
                          <i class="icon-rocket"></i>
                        </div>
                      </div>
                    </div>
                      <div class="col-md-6 report-inner-cards-wrapper">
                        <div class="report-inner-card color-2">
                        <div class="inner-card-text text-white">
                          <?php 
                        $sql2 ="SELECT * from  tblstudent";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);
$totstu=$query2->rowCount();
?>
                          <span class="report-title">Total Students</span>
                          <h4><?php echo htmlentities($totstu);?></h4>
                          <a href="manage-students.php"><span class="report-count"> View Students</span></a>
                        </div>
                        <div class="inner-card-icon ">
                          <i class="icon-user"></i>
                        </div>
                      </div>
                    </div>
                      <div class="col-md-6 report-inner-cards-wrapper">
                        <div class="report-inner-card color-3">
                        <div class="inner-card-text text-white">
                          <?php 
                        $sql3 ="SELECT * from  tblnotice";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$totnotice=$query3->rowCount();
?>
                          <span class="report-title">Total Class Notice</span>
                          <h4><?php echo htmlentities($totnotice);?></h4>
                          <a href="manage-notice.php"><span class="report-count"> View Notices</span></a>
                        </div>
                        <div class="inner-card-icon ">
                          <i class="icon-doc"></i>
                        </div>
                      </div>
                    </div>
                      <div class="col-md-6 report-inner-cards-wrapper">
                        <div class="report-inner-card color-4">
                        <div class="inner-card-text text-white">
                          <?php 
                        $sql4 ="SELECT * from  tblpublicnotice";
$query4 = $dbh -> prepare($sql4);
$query4->execute();
$results4=$query4->fetchAll(PDO::FETCH_OBJ);
$totpublicnotice=$query4->rowCount();
?>
                          <span class="report-title">Total Public Notice</span>
                          <h4><?php echo htmlentities($totpublicnotice);?></h4>
                          <a href="manage-public-notice.php"><span class="report-count"> View PublicNotices</span></a>
                        </div>
                        <div class="inner-card-icon">
                          <i class="icon-doc"></i>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div id="piechart" style="width: 100%; height: 500px;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Total Class',     4],
          ['Total Students',      10],
          ['Total Class Notice',  2],
          ['Total Public Notice', 2]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <!-- container-scroller -->
    <!-- plugins:js -->
   <?php }  ?>