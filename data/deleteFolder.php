<?php
require 'core.php';
$path = $_POST['path'];
$msg = SystemConfig::distDelete($path, []);
echo $msg;