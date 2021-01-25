<?php    
    $root = "../";
    include $root . 'db.php';
    $deleteProductID = $_GET['delid'];

    $sql1 ="UPDATE reservations SET status= 5 WHERE reservationID='$deleteProductID'";
    if($qsql1 = mysqli_query($connect,$sql1))
    {
        echo '<script>alert("Reservation Cancelled");</script>';
        header('location: viewReservationAdmin.php');
    }            
    else{
        echo '<script>alert("Reservation failed to cancel. Please try again.")</script>';
    }        
 
 ?>  