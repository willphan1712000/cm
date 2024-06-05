<?php
require 'core.php';
$g = SystemConfig::globalVariables();
$conn = Database::connection();
[$server, $username, $password] = Database::getDatabaseInfo();
$prefix = "allincli_".$_POST['product']."_";
$data = json_decode($_POST['data']);
foreach($data as $key => $value) {
    $conn = mysqli_connect($server, $username, $password, $prefix.$value);
    if(!$conn) {
        exit("Can not connect to database");
    } else {
        $showTables = mysqli_query($conn, "show tables");
        while($row = mysqli_fetch_assoc($showTables)) {
            if($row['Tables_in_'.$prefix.$value] === "isupdate") {
                $ishave = true;
            }
        }
        if($ishave !== true) {
            echo $value." does not have table isupdate<br>";
        } else {
            $query = mysqli_query($conn, "INSERT INTO isupdate VALUES('true')");
            if(!$query) {
                exit("Notification can not be sent");
            }
        }
    }
}
