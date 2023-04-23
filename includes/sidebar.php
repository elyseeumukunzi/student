<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!--  <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="assets/images/faces/face8.jpg" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper"> -->
    <?php
    // $aid= $_SESSION['sturecmsaid'];
// $sql="SELECT * from tbladmin where ID=:aid";
    
    // $query = $dbh -> prepare($sql);
// $query->bindParam(':aid',$aid,PDO::PARAM_STR);
// $query->execute();
// $results=$query->fetchAll(PDO::FETCH_OBJ);
    
    // $cnt=1;
// if($query->rowCount() > 0)
// {
// foreach($results as $row)
// {               ?>
    <!--  <p class="profile-name"><?php // echo htmlentities($row->AdminName);?></p>
                  <p class="designation"><?php //echo htmlentities($row->Email);?></p> -->
    <?php ///$cnt=$cnt+1;}} ?>
    <!--     </div>
               
              </a>
            </li> -->
    <?php
    $aid = $_SESSION['sturecmsaid'];
    $sql = "SELECT * from tbladmin where ID=:aid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':aid', $aid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    $cnt = 1;
    if ($query->rowCount() > 0) {
      foreach ($results as $row) {
        $role = $row->Role;
      }
    }
    if ($role == 'Dean') {
      ?>
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="icon-home menu-icon"></i>
          <span class="menu-title">Dashboard
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic6" aria-expanded="false" aria-controls="ui-basic">
          <i class="icon-menu menu-icon"></i>
          <span class="menu-title">Level</span>
        </a>
        <div class="collapse" id="ui-basic6">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="add-level.php">Add Level</a></li>
            <li class="nav-item"> <a class="nav-link" href="manage-level.php">Manage Levels</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="icon-layers menu-icon"></i>
          <span class="menu-title">Class</span>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="add-class.php">Add Class</a></li>
            <li class="nav-item"> <a class="nav-link" href="manage-class.php">Manage Class</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic8" aria-expanded="false" aria-controls="ui-basic1">
          <i class="icon-event menu-icon"></i>
          <span class="menu-title">Terms</span>
        </a>


        <div>
          <div class="collapse" id="ui-basic8">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="add-term.php">Add Term</a></li>
              <li class="nav-item"> <a class="nav-link" href="manage-terms.php?year=<?php echo $year; ?>">Go to Terms</a>
              </li>
            </ul>
          </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="icon-doc menu-icon"></i>
          <span class="menu-title">Special notices</span>

        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="add-notice-team.php"> To team</a></li>
            <li class="nav-item"> <a class="nav-link" href="manage-notice.php">To parents</a></li>
            <li class="nav-item"> <a class="nav-link" href="manage-notice.php">Manage S.Notices</a></li>

          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth">
          <i class="icon-doc menu-icon"></i>
          <span class="menu-title">Public Notice</span>
        </a>
        <div class="collapse" id="auth1">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="add-public-notice.php"> Add Public Notice </a></li>
            <li class="nav-item"> <a class="nav-link" href="manage-public-notice.php"> Manage Public Notice </a></li>
          </ul>
        </div>

      <li class="nav-item">
        <a class="nav-link" href="between-dates-reports.php">
          <i class="icon-flag menu-icon"></i>
          <span class="menu-title">Reports</span>
        </a>
      </li>
      <?php
    } else {

      ?>



      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="icon-home menu-icon"></i>
          <span class="menu-title">Dashboard
          </span>
        </a>
      </li>



      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
          <i class="icon-people menu-icon"></i>
          <span class="menu-title">Students</span>
        </a>
        <?php
        $thisyear = date('Y');
        $sql = "SELECT id from tblyears ORDER BY id ASC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
          foreach ($results as $row) {
            $year = $row->id;

          }
        }

        $sql = "SELECT term from tblterms WHERE yearid=:year ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':year', $year, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
          foreach ($results as $row) {
            $term = $row->term;

          }
        }
        ?>

        <div class="collapse" id="ui-basic1">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="add-students.php">Add Students</a></li>
            <li class="nav-item"> <a class="nav-link"
                href="manage-students.php?year=<?php echo $year; ?>&term=<?php echo $term; ?>&level=1">Manage Students</a>
            </li>
          </ul>
        </div>
      </li>

      <!--  Orginal Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->

      <li class="nav-item">
        <a class="nav-link" href="show-notices.php">
          <i class="icon-doc menu-icon"></i>
          <span class="menu-title">Notices</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="search.php">
          <i class="icon-magnifier menu-icon"></i>
          <span class="menu-title">Search</span>
        </a>
      </li>

      </li>
    <?php } ?>
  </ul>
</nav><!--  Orginal Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->