<?php
$root = "../";
$subtitle = 'Payment';
$nav = "rent";
include $root . 'header.php';

session_start();

include_once($root . "db.php");

$result = '';
if (!$_SESSION['reserve']) {
    header('Location: ' . $root . 'rent');
}

if (isset($_POST['confirm'])) {
    $sql = "INSERT INTO reservations(userID, bikeID, startDate, endDate,startTime, endTime, totalPrice, Comments, status) 
    VALUES ('$_SESSION[userID]','$_SESSION[bikeID]','$_SESSION[startDate]','$_SESSION[endDate]','$_SESSION[startTime]','$_SESSION[endTime]','$_SESSION[totalprice_afterdiscount]','$_SESSION[comments]', '4')";
    $qsql = mysqli_query($connect, $sql); 
    unset($_SESSION['reserve'], $_SESSION['bikeID'], $_SESSION['bikePrice'], $_SESSION['bikeName'], $_SESSION['bikeImg'], $_SESSION['startDate'],$_SESSION['endDate'],$_SESSION['startTime'],$_SESSION['endTime'],$_SESSION['totalprice_afterdiscount'],$_SESSION['comments']);

    header('Location: ' . $root . 'rent');
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo $root ?>assets/css/form.css">

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<body>
    <?php include $root . 'navbar.php' ?>
    <section>
        <?php include $root . 'sidenavigation.php' ?>
        <div class="container">
            <div class="main content-border">
                <div class="sub-content">
                    <div class="h2">Payment Summary</div>
                </div>
                <hr class="my-0">
                <form class="form-horizontal sub-content" method="post" action="<?php echo $root ?>rent/payment.php">
                    <div class="row">
                        <?php
                        if ($result != "") {
                            echo '<div class="form-group"><div class="col-sm-12 col-sm-offset-2">' . $result . '</div></div>';
                        }
                        ?>
                        <div class="col-5 pl-0 form-group">
                            <div class="h3 mb-5"><?php echo $_SESSION['bikeName'] ?></div>
                            <div class="img">
                                <img src="<?php echo $root ?>assets/img/motorbike/<?php echo $_SESSION['bikeImg']; ?>" class="w-100">
                            </div>
                        </div>
                        <div class="col pr-0">
                            <div id="detail" class="mt-3 mb-5">
                                <div class="detail-row row mb-2">
                                    <div class="detail-label col-5 pl-0">Pick up Date/Time</div>
                                    <div class="detail-value col pr-0"><input id='diff' class="custom-form-control text-left" value="<?php echo $_SESSION['startDate'] . ' ' . $_SESSION['startTime']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="detail-row row mb-2">
                                    <div class="detail-label col-5 pl-0">Drop off Date/Time</div>

                                    <div class="detail-value col pr-0"><input id='diff' class="custom-form-control text-left" value="<?php echo $_SESSION['endDate'] . ' ' . $_SESSION['endTime']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="detail-row row mb-2">
                                    <div class="detail-label col-5 pl-0">Message</div>
                                    <div class="detail-value col pr-0">
                                        <textarea class="custom-form-control custom-textarea  text-left" name="Coments" rows="3" cols="50" style="resize: none;" disabled><?php echo $_SESSION['comments']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="detail-label col-7 pl-0">Total Day(s)</div>
                                <div class="col pr-0">
                                    <input id='diff' class="custom-form-control text-right" value="<?php echo $_SESSION['diff']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="detail-label col-7 pl-0">Price Per Unit (RM)</div>
                                <div class="col pr-0">
                                    <input id='price_per_unit' class="custom-form-control text-right" value="<?php echo $_SESSION['bikePrice']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="detail-label col-7 pl-0">Total Price (RM)</div>
                                <div class="col pr-0">
                                    <input id='total_price' class="custom-form-control text-right" value="<?php echo $_SESSION['totalPrice']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-2 mb-4">
                                <div class="detail-label col-7 pl-0">Discount (RM)</div>
                                <div class="col pr-0">
                                    <input id='discount_rate' class="custom-form-control text-right" value="- <?php echo $_SESSION['discountRate']; ?>" disabled>
                                </div>
                            </div>
                            <div class="row mb-2 mb-4">
                                <div class="detail-label col-7 pl-0">Total Price After Discount(RM)</div>
                                <div class="col pr-0">
                                    <input id='total_price_to_pay' class="custom-form-control text-right" value="<?php echo $_SESSION['totalprice_afterdiscount']; ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <div class="custom-control custom-checkbox custom-checkbox-sunshine">
                                    <input type="checkbox" id="c1" class="custom-control-input custom-control-input-sunshine" name="cc" required>
                                    <label class="custom-control-label" for="c1">I agree to the <a id="contract" data-toggle="modal" href="#tnc-modal">contract</a></label>
                                </div>
                            </div>

                            <?php include $root . 't&c.html' ?>
                            <div class="form-group mt-4">
                                <div id="sendButton">
                                    <button type="submit" id="submit" class="btn btn-warning" name="confirm">Pay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="main content-border">
                <div class="forecast">
                    <?php include $root . 'forecast.php'; ?>
                </div>
            </div>
        </div>
    </section>
    <?php include $root . 'footer.html' ?>
</body>

</html>