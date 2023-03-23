<?php
include('includes/dbconnection.php');
$yearid=$_POST['yearid'];
$selectterms = "SELECT * FROM tblclass WHERE yearid=:year";
$query = $dbh->prepare($selectterms);
$query->bindParam(':year', $yearid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
 ?>
<option value="<?php echo $district["DistrictId"];?>"><?php echo $district["DistrictName"];?></option>
<?php 
}
?>
