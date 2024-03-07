<?php
$path = $_POST["path"];
function distDelete($path) {
    if(!is_dir($path)) {
        if(!unlink($path)){
            exit("Could not delete this file");
        }
    } else {
        $all = glob($path."/*", GLOB_MARK);
        if(count($all) === 0) {
            if(!rmdir($path)) {
                exit("Could not delete this folder");
            }
        } else {
            foreach($all as $a) {
                distDelete($a);
            }
            distDelete($path);
        }
    }
}
distDelete($path);