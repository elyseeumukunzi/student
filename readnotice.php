<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Code for deletion

    ?>

    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/header.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                <div class="row">
                    <div class="col-md-2 col-sm-1">
                    </div>
                    <?php
                    $noticeid = $_GET['noticeid'];
                    $sql = "SELECT * from tblpublicnotice WHERE iD = ?";
                    $query = $dbh->prepare($sql);
                    $query->execute(array($noticeid));
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>
                            <div class="col-md-8 col-sm-10 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-items-center mb-4">
                                            <h4 class="card-title mb-sm-0">
                                                <?php echo $row->NoticeTitle; ?>
                                            </h4>
                                            <a href="show-notices.php" class="text-dark ml-auto mb-3 mb-sm-0">Back home</a>
                                        </div>
                                        <div class="table-responsive border rounded p-1">
                                            <label>Dates notice: </label><?php echo $row->CreationDate;  ?><br>
                                            <br><br><br>
                                            <card><?php  echo $row->NoticeMessage; ?></card>


                                            <?php
                        }
                    } ?>

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
    <!-- container-scroller -->
<?php } ?>