<?php
require 'core.php';
$g = SystemConfig::globalVariables();
$conn = Database::connection();
[$server, $username, $password] = Database::getDatabaseInfo();
$prefix = "allincli_".$_POST['product']."_";
$querytxt = $_POST['query'];
$data = json_decode($_POST['data']);
foreach($data as $key => $value) {
    $conn = mysqli_connect($server, $username, $password, $prefix.$value);
    if(!$conn) {
        exit("One of databases is not connected");
    } else {
        $query = mysqli_query($conn, $querytxt);
        if(!$query) {
            exit("Failed to execute database");
        }
    }
}