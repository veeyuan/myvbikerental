<?php
include("adHeader.php");
include("db.php");

session_start();
if(!isset($_SESSION['adminID']))
{
    echo "<script>window.location='loginAdmin.php';</script>";
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome to Admin Panel</small>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account col-blue"></i> </div>
                <div class="content">
                    <div class="text">Total Users</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM users";
                        $qsql = mysqli_query($connect,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-bug col-blush"></i> </div>
                <div class="content">
                    <div class="text">Performing Admins</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM admin WHERE statusID = 1";
                        $qsql = mysqli_query($connect,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-balance col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Total Reservations</div>
                    <div class="number"> 
                    <?php
                        $sql = "SELECT * FROM reservations";
                        $qsql = mysqli_query($connect,$sql);
                        echo mysqli_num_rows($qsql);
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


   

    <div class="clear"></div>
</div>
</div>
<?php
include("adFooter.php");
?>
