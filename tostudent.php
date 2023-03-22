<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {

    ?><!--  Orginal Author Name: Mayuri K. 
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
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-sm-flex align-items-baseline report-summary-header">
                                            <?php
                                            if(ISSET($_GET['studentid']))
                                            {
                                            $studentid = $_GET['studentid'];
                                            $sql = "SELECT * FROM tblstudent,tbllevels,tblclass WHERE tblstudent.StudentClass = tblclass.ID AND tblclass.LevelId = tbllevels.id  AND tblstudent.ID=:studentid";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                                    ?>
                                                    <h5 class="font-weight-semibold">
                                                        <?php echo htmlentities($row->StudentName) ?>
                                                    </h5> <span class="ml-auto">Updated
                                                        Report</span> <button class="btn btn-icons border-0 p-2"><i
                                                            class="icon-refresh"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class=" col-md-6 report-inner-cards-wrapper">
                                                <div class="report-inner-card color-1">
                                                    <div class="inner-card-text text-white">
                                                        <?php
                                                        $sql1 = "SELECT * from  tblclass";
                                                        $query1 = $dbh->prepare($sql1);
                                                        $query1->execute();
                                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        $totclass = $query1->rowCount();
                                                        ?>
                                                        <span class="report-title">Total Marks this term</span>
                                                        <h4>
                                                            <?php echo htmlentities($totclass); ?>
                                                        </h4>
                                                        <a href="manage-class.php"><span class="report-count"> View
                                                                marks</span></a>
                                                    </div>
                                                    <div class="inner-card-icon">
                                                        <i class="icon-speedometer"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 report-inner-cards-wrapper">
                                                <div class="report-inner-card color-2">
                                                    <div class="inner-card-text text-white">
                                                        <?php
                                                        $sql2 = "SELECT * from  tblstudent";
                                                        $query2 = $dbh->prepare($sql2);
                                                        $query2->execute();
                                                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                        $totstu = $query2->rowCount();
                                                        ?>
                                                        <span class="report-title">Total Punishments</span>
                                                        <h4>
                                                            <?php echo htmlentities($totstu); ?>
                                                        </h4>
                                                        <a href="manage-students.php"><span class="report-count"> View
                                                                punishments</span></a>
                                                    </div>
                                                    <div class="inner-card-icon ">
                                                        <i class="icon-minus"></i>
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
                    <?php include_once('includes/footer.php'); ?>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
            </div>
            <script type="text/javascript">
                google.charts.load('current', { 'packages': ['corechart'] });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Total Class', 4],
                        ['Total Students', 10],
                        ['Total Class Notice', 2],
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
        <?php }
                                            }
} 
}?>