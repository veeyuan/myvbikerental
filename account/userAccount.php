<?php
$root = "../";
include $root . 'account/adHeader.php';
include $root . 'db.php';
if (!isset($_SESSION['userID'])) {
    header('Location: ' . $root . 'account/login.php');
}

$sql = "SELECT * FROM users WHERE userID = '$_SESSION[userID]' ";
$qsql = mysqli_query($connect, $sql);
$rs = mysqli_fetch_array($qsql);
?>

<style>
    .container {
        position: relative;
        width: 100%;
    }

    .container .button {
        position: absolute;
        top: 61%;
        left: 11%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: #02aab0;
        font-size: 16px;
        color: white;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        text-align: center;
    }

    .container .button:hover {
        background-color: white;
        color: black;
    }
</style>

<div class=" container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome to MY V Bike Rental</small>
    </div>

    <div class="card">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="alert bg-teal">
                            <h3>Welcome , <?php echo $rs['username']; ?> !</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container px-0 mx-0">
            <div class="col-lg-12 col-md-12 col-sm-12">
            <img src="<?php echo $root; ?>assets/img/biking.png" class="w-100"  alt="bike" style="height:400px;">
            <button class="button" onclick="document.location='<?php echo $root; ?>rent'">Reserve a bike</button>
            </div>
        </div>
    </div>
</div>

<?php include $root . 'account/adFooter.php'; ?>