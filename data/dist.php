<?php
require "config.php";
$from = "../".$_POST['product']."/";
$to = "../../";
$data = $_POST['data'];
$data = json_decode($data);
// Function for copying the entire folder
function copyfolder($from, $to) {
    // Check original folder
    if(!is_dir($from)) {
        exit("$from does not exist");
    }
    // // Check the destination folder, if not exist, create one
    if(!is_dir($to)) {
        if(!mkdir($to)) {
            exit("Failed to create $to");
        }
    }
    // Get all files and folders in source
    $all1 = glob("$from*", GLOB_MARK);
    $all2 = glob("$from.*", GLOB_MARK);
    $all = array_merge($all1, $all2);
    // Copy files + Recursive Internal Folders
    if(count($all) > 0) {
        foreach($all as $a) {
            $ff = basename($a); // Get current file, folder name
            if($ff === ".") continue;
            if($ff === "..") continue;
            if($ff === ".DS_Store") continue;
            if(is_dir($a)) {
                copyfolder("$from$ff/","$to$ff/");
            } else {
                if(!copy($a, "$to$ff")) {
                    exit("Error of copying");
                }
            }
        }
    }
}
foreach($data as $key => $value) {
    $folderName = str_replace('_','.',$value);
    copyfolder($from, $to.$folderName."/");
}
foreach($data as $key => $value) {
    // Below is to update tech files
    $folderName = str_replace('_','.',$value);
    $pathToTech = $to.$folderName."/admin/tech/";
    if(file_exists($pathToTech)) {
        $conn = mysqli_connect($server,$username,$password, "allincli_p_".$value);
        if(!$conn) {
            exit("Can not connect to database");
        } else {
            $tech = mysqli_query($conn,"SELECT id FROM tech");
            while ($row = mysqli_fetch_array($tech)) {
                $techIndex = file_get_contents($pathToTech.'techIndex.txt');
                $techAdmin = file_get_contents($pathToTech.'adminTech/techAdmin.txt');
                $techAdminIndex = file_get_contents($pathToTech.'adminTech/techAdminIndex.txt');
                $techIndexPhp = fopen($pathToTech.$row['id'].".php","w");
                $techAdminPhp = fopen($pathToTech."adminTech/".$row['id'].".php", "w");
                $techAdminIndexPhp = fopen($pathToTech."adminTech/index_".$row['id'].".php", "w");
                fwrite($techIndexPhp, $techIndex);
                fwrite($techAdminPhp, $techAdmin);
                fwrite($techAdminIndexPhp, $techAdminIndex);
                fclose($techIndexPhp);
                fclose($techAdminPhp);
                fclose($techAdminIndexPhp);
            }
        }
    }
}
