<?php
$prePath = "../".$_POST['product']."/";
$file = $_POST['file'];
$path = $prePath.$file;
if(!file_exists($path)) {
    if(!str_contains($file, ".")) {
        mkdir($path, 0755, true);
        $folder = explode("/", $file);
        for($i=0;$i<count($folder);$i++) {
            $arr = "";
            for($j=0;$j<=$i;$j++) {
                $arr = $arr.$folder[$j]."/";
            }
            if(!is_writable($prePath.$arr)) {
                if(!chmod($prePath.$arr, 0755)) {
                    echo "Failed to change permission";
                    break;
                }
            }
        }
    } else {
        if(!fopen($path, "w")) {
            echo "Could not create the file, please try again!";
        }
    }
} else {
    echo "The file exists";
}