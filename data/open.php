<?php
$path = $_POST['path'];
$content = file_get_contents($path);
echo $content;