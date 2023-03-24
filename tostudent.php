<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['punish'])) {
        $studentid = isset($_GET['studentid']);        
        $thisyear=date('Y');
         $sql = "SELECT id from tblyears WHERE year=:year";
         $query = $dbh->prepare($sql);
         $query->bindParam(':year', $thisyear, PDO::PARAM_STR);
         $query->execute();
         $results = $query->fetchAll(PDO::FETCH_OBJ);       
         if ($query->rowCount() > 0) {
           foreach ($results as $row) { 
            $year=$row->id;
  
           }}           
           $sql = "SELECT tblsconducts.marks,tblsconducts.id from tblterms,tblsconducts WHERE tblterms.id=tblsconducts.termid AND tblterms.yearid=:year";
           $query = $dbh->prepare($sql);
           $query->bindParam(':year', $year, PDO::PARAM_STR);
           $query->execute();
           $results = $query->fetchAll(PDO::FETCH_OBJ);       
           if ($query->rowCount() > 0) {
             foreach ($results as $row) { 
              $conduct=$row->id;
    
             }}             
        $fault = $_POST['fault'];
        $marks = $_POST['marks'];
        $newmarks=$row->marks - $marks;
        $description = $_POST['description'];
        $userid= $_SESSION['sturecmsaid'];        
        $sql = "insert into tblpunishments(fault,description,marks,conductid,userid)values(:fault,:description,:marks,:conductid,:userid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fault', $fault, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':marks', $marks, PDO::PARAM_STR);
        $query->bindParam(':conductid', $conduct, PDO::PARAM_STR);
        $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        $query->execute();
        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("Punishmen added")</script>';
            echo "<script>window.location.href ='tostudent.php?studentid=$studentid'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }

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
                                            if (isset($_GET['studentid'])) {
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
                                                        </h5> <span class="ml-auto"></span>
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page">To student</li>
                                                        </ol>
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
                                                <br>

                                                <div class="row" style="margin-top:20px">
                                                    <div class="col-md-6">
                                                        <label>Punishments this term</label>
                                                    </div>
                                                    <div class="col-md-3">
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
                                                    <div class="col-md-3">
                                                        <a href="edit-class-detail.php?editid=<?php echo htmlentities($row->id); ?>"
                                                            class="btn btn-primary btn-sm"><i class="icon-magnifier"></i></a>
                                                    </div>
                                                </div>

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="font-weight-bold">No</th>
                                                            <th class="font-weight-bold">Mistake</th>
                                                            <th class="font-weight-bold">Punishments</th>
                                                            <th class="font-weight-bold">Dates</th>
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

                                                        $sql = "SELECT * from tbllevels LIMIT $offset, $no_of_records_per_page";
                                                        $query = $dbh->prepare($sql);
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
                                                                        <?php echo htmlentities($row->levelname); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo htmlentities($row->description); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo htmlentities($row->createdDates); ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="edit-class-detail.php?editid=<?php echo htmlentities($row->id); ?>"
                                                                            class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                                        <a href="manage-level.php?delid=<?php echo ($row->id); ?>"
                                                                            onclick="return confirm('Do you really want to Delete ?');"
                                                                            class="btn btn-danger btn-sm"> <i class="icon-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php $cnt = $cnt + 1;
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <P>new punishment</P>

                                                    <form class="forms-sample" method="POST">

                                                        <div class="form-group">
                                                            <label for="exampleInputName1">Fault Name</label>
                                                            <input type="text" name="fault" value="" class="form-control"
                                                                required='true' placeholder="write mistake here">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail3">Punishment Marks</label>
                                                            <input type="number" name="marks" value="" class="form-control"
                                                                required='true' placeholder="removed conducts marks">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail3">Description</label>
                                                            <div class="form-group col-md-12">
                                                                <textarea name="description" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mr-2" name="punish">Save</button>

                                                    </form>
                                                </div>
                                                <div class="col-md-4 card">
                                                    <div class="report-inner-cards-wrapper">
                                                        <div class="report-inner-card color-2">
                                                            <div class="inner-card-text text-white">
                                                                <?php
                                                                $sql2 = "SELECT * from  tblstudent";
                                                                $query2 = $dbh->prepare($sql2);
                                                                $query2->execute();
                                                                $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                                $totstu = $query2->rowCount();
                                                                ?>
                                                                <span class="report-title">Common mistakes</span>
                                                                <h4>
                                                                    <?php echo htmlentities($totstu); ?>
                                                                </h4>
                                                                <a href="manage-students.php"><span class="report-count"> View
                                                                        punishments</span></a>
                                                            </div>
                                                            <div class="inner-card-icon ">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
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
}
?>