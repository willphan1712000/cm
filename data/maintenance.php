<?php
$title = "Code Management";
$sessionDuration = 60*20; // 20 minutes
$v = 2.2;
$copyright = '© '.date("Y").' Allinclicks. All rights reserved.';
$phpversion = '. PHP Version: '.phpversion();

function product() {
    return [[
        "p" => "Portfolio",
        "vtv" => "VTV",
        "htv" => "HTV"
    ],
    [
        "p" => '<i class="fa-solid fa-image"></i>',
        "vtv" => '<i class="fa-sharp fa-solid fa-tv"></i>',
        "htv" => '<i class="fa-sharp fa-solid fa-tv"></i>'
    ]];
}

function dd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function iconClassification($ele) {
    if(str_contains($ele,".")) {
        $img = end(explode(".", $ele));
        $arrOfIcon = ["css", "gif", "html", "ico", "jpeg", "jpg", "js", "json", "md", "mp4", "php", "png", "txt"];
        $has = false;
        foreach($arrOfIcon as $ext) {
            if($img === $ext) {
                $has = true;
                break;
            }
            if(str_contains($img, "git")) {
                $img = "git";
                $has = true;
                break;
            }
        }
        if(!$has) {
            $img = "else";
        }
    } else {
        $img = "folder";
    }
    return $img;
}