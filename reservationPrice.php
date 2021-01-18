<?php
include_once("db.php");                                     

$var1 = 0;
$var2 = 1;
if(isset($_POST['var1'])){
    $var1 = $_POST['var1'];
}
// if(isset($_POST['var2'])){
//     $var2 = $_POST['var2'];
// }



$sql = "SELECT * FROM `bikes` WHERE ID = '$var1'";
$result = mysqli_query($connect,$sql);
while($row = mysqli_fetch_array($result)){
echo $row['Price per day'] * $var2 ;
    
}
?>
