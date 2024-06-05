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
$product = basename(parse_url($_SERVER['REQUEST_URI'])["path"]);
$root = SystemConfig::getRootDir().$product;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$g['title'];?></title>
    <script src="https://kit.fontawesome.com/960d33c629.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script defer src="/dist/mainec01b1067114c1724b8e.js"></script><script defer src="/dist/universal3822cbb87a5a56f60e2c.js"></script><script defer src="/dist/style4ca2fd3a6f68b579cfa1.js"></script><script defer src="/dist/p4fa0ea8126a9853172ce.js"></script><script defer src="/dist/responsive85a42f4d516c9a121a3d.js"></script></head>
<body>
    <div id="root"></div>
    <script>
        var type = "product";
        var product = "<?=$product;?>";
        var props = {
            g: <?= json_encode($g); ?>,
            displayDirectoryHtml: '<?= SystemConfig::displayDirectory($root)?>',
            showListOfWeb: '<?php SystemConfig::showListOfWeb($conn, $product);?>',
            product: "<?=$product;?>",
            type: "product"
        }
    </script>
</body>
</html>