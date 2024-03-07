<?php
$path = $_POST['path'];
$data = json_decode($_POST['data']);
function distDelete($path) {
    if(!file_exists($path)) {
        exit("The file or folder does not exist!");
    } else {
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
}
foreach($data as $key => $value) {
    $folderName = str_replace('_','.',$value);
    distDelete("../../".$folderName."/".$path);
}