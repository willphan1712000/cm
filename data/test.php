<?php
require 'core.php';
function distDelete($path, $exception) {
    if(!is_dir($path)) {
        chmod($path, 0666);
        if(!unlink($path)){
            return "Could not delete this file ".$path;
        }
    } else {
        $all1 = glob($path."/*", GLOB_MARK);
        $all2 = glob($path."/.*", GLOB_MARK);
        $all = array_merge($all1, $all2);
        // var_dump($all);
        // die();
        foreach($all as $a) {
            $ff = basename($a);
            if($ff === ".") continue;
            if($ff === "..") continue;
            if(in_array($ff, $exception)) continue;
            distDelete($a, $exception);
        }
        chmod($path, 0777);
        rmdir($path);
    }
    return "Delete success";
}
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

// copyfolder("../ori/", "../des/");
echo distDelete("/Applications/XAMPP/xamppfiles/htdocs/source/vtv/u", []);