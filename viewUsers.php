<?php
include("adFormHeader.php");
include("db.php");
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM users WHERE userID='$_GET[delid]'";
	$qsql=mysqli_query($connect,$sql);
	if(mysqli_affected_rows($connect) == 1)
	{
		echo "<script>alert('User record deleted successfully');</script>";
	}
}
?>

<div class="container-fluid">
  <div class="block-header">
    View User Record
  </div>
</div>
<div class="card">
  <section class="container">
   <table class="table table-bordered table-striped table-hover js-basic-example dataTable">


    <thead>
      <tr>
        <td width="8%" height="40">Username</td>
        <td width="9%">Email</td>
        <td width="8%">Mobile Number</td>
        <td width="12%">Address</td>
		<td width="8%">Action</td>
      </tr>
    </thead>
    <tbody>
     <?php          
     $sql ="SELECT * FROM users";
     $qsql = mysqli_query($connect,$sql);
     while($rs = mysqli_fetch_array($qsql))
     {
      echo "<tr>
      <td>$rs[username]</td>
      <td>$rs[email]</td>
      <td>$rs[mobileNo]</td>
	  <td>$rs[address]</td>
      <td style='min-width: 180px'>
      <a href='users.php?editid=$rs[userID]' class='btn btn-raised g-bg-cyan'>Edit</a> <a href='viewUsers.php?delid=$rs[userID]' class='btn btn-raised g-bg-blush2'>Delete</a> </td>
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