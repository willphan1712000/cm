<?php
$g = SystemConfig::globalVariables();
$conn = Database::connection();
SESSION_START();
if(isset($_SESSION['username'])) {
    if($_SESSION['last_time_admin']-time() > $g['sessionDuration']) {
        header("Location: /");
    } else {
        $_SESSION['last_time_admin'] = time();
    }
} else {
    header("Location: /");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$g['title'];?></title>
    <script src="https://kit.fontawesome.com/d90d2a7e36.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script defer src="/dist/mainca76fd37822be6fe1eed.js"></script><script defer src="/dist/universal3822cbb87a5a56f60e2c.js"></script><script defer src="/dist/style4ca2fd3a6f68b579cfa1.js"></script><script defer src="/dist/p3f6c05061edb0d495cfd.js"></script><script defer src="/dist/responsive85a42f4d516c9a121a3d.js"></script></head>
<body>
    <div id="root"></div>
    <script>
        var type = "stats";
        var props = {
            g: <?= json_encode($g); ?>,
            product: "stats"
        }
    </script>
</body>
</html>