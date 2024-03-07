<?php
include "maintenance.php";
require "config.php";
switch($_POST['request']) {
    case 'p':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE '%allincli\_p\_%'");
            $i = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $i++;
            }
            echo $i;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    case 'vtv':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_vtv\_%'");
            $i = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $i++;
            }
            echo $i;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    case 'p_mimg':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_p\_%'");
            $count = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_p\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM techimg");
                while($row = mysqli_fetch_assoc($query)) {
                    $count++; 
                }
            }
            echo $count;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    case 'p_tvimg':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_p\_%'");
            $count = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_p\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM techtvimage");
                while($row = mysqli_fetch_assoc($query)) {
                    $count++; 
                }
            }
            echo $count;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    case 'vtv_tvimg':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_vtv\_%'");
            $count = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_vtv\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM tvfile");
                while($row = mysqli_fetch_assoc($query)) {
                    $count++; 
                }
            }
            echo $count;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    case 'htv':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_htv\_%'");
            $i = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $i++;
            }
            echo $i;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    case 'htv_tvimg':
        if($conn) {
            $db_list = mysqli_query($conn, "SHOW DATABASES LIKE 'allincli\_htv\_%'");
            $count = 0;
            while($row = mysqli_fetch_assoc($db_list)) {
                $conn = mysqli_connect($server, $username, $password, $row['Database (allincli\_htv\_%)']);
                $query = mysqli_query($conn, "SELECT *FROM tvfile");
                while($row = mysqli_fetch_assoc($query)) {
                    $count++; 
                }
            }
            echo $count;
        } else {
            echo "Error connecting database: " . mysqli_error($conn);
        }
        break;
    default:
        break;
}