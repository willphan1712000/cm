<?php
require "config.php";
include "maintenance.php";
if($conn) {
    if(isset($_POST['date']) && isset($_POST['req']) && isset($_POST['name'])) {
        $req = $_POST['req'];
        $date = $_POST['date'];
        $name = $_POST['name'];
        $db = 'allincli_'.$req.'_'.str_replace('.','_',$name);
        $conn = mysqli_connect($server, $username, $password, $db);
        mysqli_query($conn, "DELETE FROM subscription");
        if($date !== 'Not subscribed') {
            mysqli_query($conn, "INSERT INTO subscription VALUES('$date')");
        }
    }
} else {
    echo "Error connecting database: " . mysqli_error($conn);
}