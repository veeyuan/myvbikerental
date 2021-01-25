<?php
$root = "../";
include_once($root . "db.php");
                                 

$var1 = 0;
$var2 = 1;
if(isset($_POST['var1'])){
    $var1 = $_POST['var1'];
}

$sql = "SELECT * FROM `models` WHERE brand = '$var1'";
$result = mysqli_query($connect,$sql);
while($row = mysqli_fetch_array($result)){
echo $row['price'] * $var2 ;
    
}
?>
