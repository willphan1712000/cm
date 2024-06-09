<?php
$path = $_POST['path'];
$change = $_POST['change'];
$array = explode("/", $path);
array_pop($array);
$pathWithoutChange = implode("/", $array);
if(!rename($path, $pathWithoutChange."/".$change)) {
    echo "Rename failed";
};