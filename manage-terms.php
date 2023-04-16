<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    <h3 class="page-title"> Manage Terms </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Manage terms</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" Action="manage-terms.php">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="year" class="form-control" required='true'>
                                                <option>Filter year</option>
                                                <?php
                                                $sql = "SELECT * FROM tblyears";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $thisyear = date('Y');
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {

                                                        ?>
                                                        <option value="<?php echo htmlentities($row->id) ?>"><?php echo htmlentities($row->year); ?> </option>
                                                    <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary"><i> Filter</button></i>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">Term ID</th>
                                                    <th class="font-weight-bold">Term</th>
                                                    <th class="font-weight-bold">Starting date</th>

                                                    <th class="font-weight-bold">ending date Date</th>
                                                    <th class="font-weight-bold">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                // Formula for pagination
                                                $no_of_records_per_page = 15;
                                                $offset = ($pageno - 1) * $no_of_records_per_page;
                                                $ret = "SELECT ID FROM tblstudent";
                                                $query1 = $dbh->prepare($ret);
                                                $query1->execute();
                                                $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                $total_rows = $query1->rowCount();
                                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                                $yearid=$_GET['year'];
                                                $sql = "SELECT * FROM tblterms WHERE yearid = ?";
                                                $query = $dbh->prepare($sql);
                                                $query->execute(array($yearid));
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo htmlentities($row->id); ?>
                                                            </td>
                                                            <td>
                                                                <?php $term = htmlentities($row->term);
                                                                if ($term == 1) {
                                                                    echo $term . "st Term";
                                                                } elseif ($term == 2) {
                                                                    echo $term . "nd Term";

                                                                } elseif ($term == 3) {
                                                                    echo $term . "rd Term";

                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlentities($row->fromdates); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo htmlentities($row->todates); ?>

                                                            </td>
                                                            <td>
                                                                <a href="tostudent.php?studentid=<?php echo htmlentities($row->ID) ?>"
                                                                    class="btn btn-primary btn-sm"><i class="icon-notebook"></i></a>
                                                                <a href="edit-student-detail.php?editid=<?php echo htmlentities($row->ID); ?>"
                                                                    class="btn btn-primary btn-sm"><i class="icon-eye"></i></a>
                                                                <a href="manage-students.php?delid=<?php echo ($row->ID); ?>"
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
                                    <div align="left">

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