<?php
$root = "../";
include $root . 'db.php';

include $root . "account/adHeader.php";

if (isset($_POST['submit'])) {
    $sql = "UPDATE users SET password='$_POST[newpassword]' WHERE password='$_POST[oldpassword]' AND userID='$_SESSION[userID]'";
    $qsql = mysqli_query($connect, $sql);
    if (mysqli_affected_rows($connect) == 1) {
        echo "<div class='alert alert-success'>
                            Password has been updated successfully
                        </div>
                        <script>alert('Password has been updated successfully');</script>";
    } else {
        echo "<div class='alert alert-danger'>
                            Update Failed
                        </div>
                       ";
    }
}
?>

<div class="container-fluid">
    <div class="block-header">
        <h2> User's Password</h2>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form method="post" action="" name="frmpatchange" onSubmit="return validateform()" style="padding: 10px">
                    <div class="form-group">
                        <label>Old Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="oldpassword" id="oldpassword" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="newpassword" id="newpassword" />

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="form-line">
                            <input class="form-control" type="password" name="password" id="password" />
                        </div>
                    </div>

                    <input class="btn btn-raised g-bg-cyan" type="submit" name="submit" id="submit" value="Submit" />


                </form>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>

<?php include $root . "account/adfooter.php"; ?>
<script type="application/javascript">
    function validateform() {
        if (document.frmpatchange.oldpassword.value == "") {
            alert("Old password should not be empty..");
            document.frmpatchange.oldpassword.focus();
            return false;
        } else if (document.frmpatchange.newpassword.value == "") {
            alert("New Password should not be empty..");
            document.frmpatchange.newpassword.focus();
            return false;
        } else if (document.frmpatchange.newpassword.value.length < 6) {
            alert("New Password length should be more than 6 characters...");
            document.frmpatchange.newpassword.focus();
            return false;
        } else if (document.frmpatchange.newpassword.value != document.frmpatchange.password.value) {
            alert(" New Password and confirm password should be equal..");
            document.frmpatchange.password.focus();
            return false;
        } else {
            return true;
        }
    }
</script>