<?php
$root = "../";
include $root . 'db.php';

include $root . "account/adHeader.php";

session_start();

if (!isset($_SESSION['adminID'])) {
    header('Location: ' . $root . 'account/loginAdmin.php');
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
                        $qsql = mysqli_query($connect, $sql);
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
                        $qsql = mysqli_query($connect, $sql);
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
                        $qsql = mysqli_query($connect, $sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $rows = '';
    $query = "SELECT SUM(totalPrice) AS totalPrice, MONTH(startDate) AS startDate FROM reservations GROUP BY MONTH(startDate)";
    $result = mysqli_query($connect, $query);
    $total_rows =  $result->num_rows;
    // echo '<script>console.log('.$total_rows.')</script>';            
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo '<script>console.log(' . json_encode($rows) . ')</script>';
    }


    // $query = "SELECT SUM(totalPrice) AS total, startDate FROM reservations GROUP BY startDate";
    // $result = mysqli_query($connect,$query);
    // $chart_data = array(); //declare an array, not a string. This will become the outer array of the JSON.

    // while($row = mysqli_fetch_array($result)) { 
    //     //add a new item to the array
    //     //each new item is an associative array with key-value pairs - this will become an object in the JSON
    //     $chart_data [] = array(
    //       "total" => $row["total"], 
    //       "startDate" => $row["startDate"]
    //     ); 
    // } 

    // $json = json_encode($chart_data);  //encode the array into a valid JSON object
    // echo '<script>console.log('.$json.')</script>';          
    ?>
    <div class="col-xs-12" id="morris-line-chart"></div>
    <div class="clear"></div>
    <script>
        const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'morris-line-chart',

            // Chart data records -- each entry in this array corresponds to a point
            // on the chart.
            data: <?php echo json_encode($rows); ?>,

            // The name of the data record attribute that contains x-values.
            xkey: 'startDate',

            // A list of names of data record attributes that contain y-values.
            ykeys: ['totalPrice'],

            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['TotalPrice'],

            lineColors: ['#0b62a4'],

            xLabelFormat: function(x) {
                var index = parseInt(x.src.startDate);
                return monthNames[index];
            },
            xLabels: 'date',
            parseTime: false,
            // Disables line smoothing
            smooth: true,
            resize: true
        });
    </script>
</div>
</div>
<?php include $root . "account/adFooter.php"; ?>