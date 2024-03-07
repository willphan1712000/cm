<?php
require "config.php";
$prefix = "allincli_".$_POST['product']."_";
$site = json_decode($_POST['site']);
$dbNew = json_decode($_POST['db']);
$queryArr = json_decode($_POST['queryArr']);
$changeCount = 0;
$unChangeCount = 0;
foreach ($site as $key => $value) {
    $conn = mysqli_connect($server, $username, $password, $prefix.$value);
    if(!$conn) {
        exit("One of databases is not connected");
    } else {
        $db = new stdClass();

        $tablesQuery = mysqli_query($conn, "show tables");
        while($row = mysqli_fetch_assoc($tablesQuery)) {
            $table = $row['Tables_in_'.$prefix.$value];
            $db->{$table} = array();
            $columnsQuery = mysqli_query($conn, "show columns from ".$table);
            while($row = mysqli_fetch_assoc($columnsQuery)) {
                $column = $row['Field'];
                array_push($db->$table, $column);
            }
        }

        $nstro = compareObjects($dbNew, $db);
        $ostrn = compareObjects($db, $dbNew);
        $queryArrNew = action($nstro, $ostrn, $queryArr);
        if($queryArrNew) {
            foreach($queryArrNew as $queryNew) {
                $query = mysqli_query($conn, $queryNew);
            }
            $changeCount++;
        } 
        else {
            $unChangeCount++;
        }
    }
}
// echo json_encode($queryArrNew);
echo json_encode([$changeCount, $unChangeCount]);
function compareObjects($obj1, $obj2) {
    // Get the property names of the objects
    $props1 = get_object_vars($obj1);
    $props2 = get_object_vars($obj2);

    // Create an array to store the differences
    $table = [];
    $column = [];

    // Compare each property
    foreach ($props1 as $name => $value1) {
        // Check if the corresponding property exists in the second object
        if (!isset($props2[$name])) {
            $table[$name] = $value1;
        } else {
            $value2 = $props2[$name];
            $eachColumn = [];
            foreach($value1 as $value) {
                if(!in_array($value, $value2)) {
                    $eachColumn[] = $value;
                    $column[$name] = $eachColumn;
                }
            }
        }
    }
    return [$table, $column];
}
function checkEmpty($array) {
    foreach($array as $ele) {
        if(!empty($ele)) {
            return false;
        }
    }
    return true;
}
function action($nstro, $ostrn, $queryArr) {
    if (checkEmpty($nstro) && checkEmpty($ostrn)) {
        return false;
    } 
    else {
        $queryArrNew = [];
        $queryArrProps = get_object_vars((object) $queryArr);
        if(!checkEmpty($ostrn[0])) {
            foreach($ostrn[0] as $table => $column) {
                $queryArrNew[] = "DROP TABLE ".$table;
            }
        }
        if(!checkEmpty($ostrn[1])) {
            foreach($ostrn[1] as $table => $columns) {
                foreach($columns as $column) {
                    $queryArrNew[] = "ALTER TABLE ".$table." DROP COLUMN ".$column;
                }
            }
        }
        if(!checkEmpty($nstro[0])) {
            foreach($nstro[0] as $t => $cs) {
                foreach($queryArrProps as $table => $columns) {
                    $string = '';
                    if(str_contains($table, "`".$t."`")) {
                        $string .= $table;
                        foreach($columns as $column) {
                            $string .= $column;
                        }
                        $queryArrNew[] = $string;
                        break;
                    }
                }
            }
        }
        if(!checkEmpty($nstro[1])) {
            foreach($nstro[1] as $t => $cs) {
                foreach($queryArrProps as $table => $columns) {
                    if(str_contains($table, "`".$t."`")) {
                        foreach($cs as $c) {
                            foreach($columns as $column) {
                                if(str_contains($column, "`".$c."`")) {
                                    $modifiedColumn = '';
                                        if(substr($column, -1) === ',') {
                                            $modifiedColumn = explode(",", $column)[0];
                                        } else {
                                            $modifiedColumn = $column;
                                        }
                                    $queryArrNew[] = "ALTER TABLE ".$t." ADD ".$modifiedColumn;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $queryArrNew;
    }
}