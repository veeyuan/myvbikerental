<?php
include("adFormHeader.php");
include("db.php");
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM bikes WHERE ID='$_GET[delid]'";
	$qsql=mysqli_query($connect,$sql);
	if(mysqli_affected_rows($connect) == 1)
	{
		echo "<script>alert('Bike record deleted successfully');</script>";
	}
}
?>

<div class="container-fluid">
  <div class="block-header">
    View Bikes Record
  </div>
</div>
<div class="card">
  <section class="container">
   <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

    <thead>
      <tr>
        <td width="12%" height="40">Model</td>
        <td width="11%">Plate Number</td>
        <td width="12%">Status</td>
        <td width="10%">Action</td>
      </tr>
    </thead>
    <tbody>
     <?php          
     $sql ="SELECT * FROM Bikes";
     $qsql = mysqli_query($connect,$sql);
     while($rs = mysqli_fetch_array($qsql))
     {
         $status = "";
         if($rs['status'] == 1){
            $status = "Available";
         }
         else if($rs['status'] == 2){
            $status = "Checked Out";
         }         
		else if($rs['status'] == 3){
            $status = "Not Available";
         }         
		 else if($rs['status'] == 4){
            $status = "On Hold";
         }
		 
		$model = "";
         if($rs['model'] == 1){
            $model = "Model 1";
         }
         else if($rs['model'] == 2){
            $model = "Model 2";
         } 
      echo "<tr>
      <td>$model</td>
      <td>$rs[plate_no]</td>
      <td>$status</td>
      <td style='min-width: 180px'>
      <a href='addBikes.php?editid=$rs[adminID]' class='btn btn-raised g-bg-cyan'>Edit</a> <a href='viewBikes.php?delid=$rs[ID]' class='btn btn-raised g-bg-blush2'>Delete</a> </td>
      </tr>";
    }
    ?>
  </tbody>
</table>
</section>

</div>
</div>



<?php
include("adFormFooter.php");
?>