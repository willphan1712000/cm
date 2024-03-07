<?php
require "config.php";
include "maintenance.php";
if($conn) {
    if(isset($_POST['searchReq'])) {
        $req = $_POST['searchReq'];
        $db_list = "";
        if($req === "p") {
            $i = 1;
            $arr = array();
            class pComponent {
                public $order;
                public $name;
                public $username;
                public $password;
                public $tech;
                public $mobile;
                public $tv;
                public $subscription;
            }
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_".$req."\_%'");
            while($row = mysqli_fetch_assoc($db_list)) {
                $name = str_replace('allincli_p_','',$row['Database (allincli\_'.$req.'\_%)']);
                $name = str_replace('_','.',$name);
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_'.$req.'\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM login");
                if(mysqli_num_rows($query) > 0) {
                    while($row1 = mysqli_fetch_array($query)) {
                        $owner = $row1['owner'];
                        $passcode = $row1['password'];
                    }
                } else {
                    $owner = "NA";
                    $passcode = "NA";
                }
                $query = mysqli_query($conn, "SELECT *FROM tech");
                $techCount = 0;
                while($row = mysqli_fetch_assoc($query)) {
                    $techCount++;
                }
                $query = mysqli_query($conn, "SELECT *FROM techimg");
                $counttechimg = 0;
                while($row = mysqli_fetch_assoc($query)) {
                    $counttechimg++;
                }
                $query = mysqli_query($conn, "SELECT *FROM techtvimage");
                $counttechtvimage = 0;
                while($row = mysqli_fetch_assoc($query)) {
                    $counttechtvimage++;
                }
                $sub = mysqli_query($conn, "SELECT *FROM subscription");
                $pComponent = new pComponent();
                $pComponent->order = $i;
                $pComponent->name = $name;
                $pComponent->username = $owner;
                $pComponent->password = $passcode;
                $pComponent->tech = $techCount;
                $pComponent->mobile = $counttechimg;
                $pComponent->tv = $counttechtvimage;
                $pComponent->sub = mysqli_fetch_array($sub)[0];
                array_push($arr, $pComponent);
                $i++; 
            }
            echo json_encode($arr);
        } elseif ($req === "vtv") {
            $j = 1;
            $arrTV = array();
            class tvComponent {
                public $order;
                public $name;
                public $username;
                public $password;
                public $mobile;
                public $tv;
                public $sub;
            }
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_".$req."\_%'");
            while($row = mysqli_fetch_assoc($db_list)) {
                $name = str_replace('allincli_vtv_','',$row['Database (allincli\_'.$req.'\_%)']);
                $name = str_replace('_','.',$name);
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_'.$req.'\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM login");
                if(mysqli_num_rows($query) > 0) {
                    while($row1 = mysqli_fetch_array($query)) {
                        $owner = $row1['owner'];
                        $passcode = $row1['password'];
                    }
                } else {
                    $owner = "NA";
                    $passcode = "NA";
                }
                $query = mysqli_query($conn, "SELECT *FROM tvfile");
                $counttechtvimage = 0;
                while($row = mysqli_fetch_assoc($query)) {
                    $counttechtvimage++;
                }
                $sub = mysqli_query($conn, "SELECT *FROM subscription");
                $tvComponent = new tvComponent();
                $tvComponent->order = $j;
                $tvComponent->name = $name;
                $tvComponent->username = $owner;
                $tvComponent->password = $passcode;
                $tvComponent->tv = $counttechtvimage;
                $tvComponent->sub = mysqli_fetch_array($sub)[0];
                array_push($arrTV, $tvComponent);
                $j++;
            }
            echo json_encode($arrTV);
        } elseif ($req === "htv") {
            $j = 1;
            $arrTV = array();
            class tvComponent {
                public $order;
                public $name;
                public $username;
                public $password;
                public $mobile;
                public $tv;
                public $sub;
            }
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_".$req."\_%'");
            while($row = mysqli_fetch_assoc($db_list)) {
                $name = str_replace('allincli_htv_','',$row['Database (allincli\_'.$req.'\_%)']);
                $name = str_replace('_','.',$name);
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_'.$req.'\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM login");
                if(mysqli_num_rows($query) > 0) {
                    while($row1 = mysqli_fetch_array($query)) {
                        $owner = $row1['owner'];
                        $passcode = $row1['password'];
                    }
                } else {
                    $owner = "NA";
                    $passcode = "NA";
                }
                $query = mysqli_query($conn, "SELECT *FROM tvfile");
                $counttechtvimage = 0;
                while($row = mysqli_fetch_assoc($query)) {
                    $counttechtvimage++;
                }
                $sub = mysqli_query($conn, "SELECT *FROM subscription");
                $tvComponent = new tvComponent();
                $tvComponent->order = $j;
                $tvComponent->name = $name;
                $tvComponent->username = $owner;
                $tvComponent->password = $passcode;
                $tvComponent->tv = $counttechtvimage;
                $tvComponent->sub = mysqli_fetch_array($sub)[0];
                array_push($arrTV, $tvComponent);
                $j++;
            }
            echo json_encode($arrTV);
        }
    }
} else {
    echo "Error connecting database: " . mysqli_error($conn);
}