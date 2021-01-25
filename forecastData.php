<?php
$response = file_get_contents("forecastdata.json");
$data = json_decode($response);
$weatherdata = $data->data;
$filedate =  $weatherdata[0]->valid_date;
if ($filedate !== date("Y-m-d")) {
    include 'forecastAPI.php';
}
?>