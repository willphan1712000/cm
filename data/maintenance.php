<?php
$title = "Code Management";
$sessionDuration = 60*20; // 20 minutes
$v = 2;
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