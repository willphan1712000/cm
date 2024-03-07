<?php
include "data/maintenance.php";
require "data/config.php";
SESSION_START();
if(isset($_SESSION['username'])) {
    if($_SESSION['last_time_admin']-time() > $sessionDuration) {
        header("Location: /");
    } else {
        $_SESSION['last_time_admin'] = time();
    }
} else {
    header("Location: /");
}
$product = "htv";
$listOfProduct = product();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="css/universal.css?v=<?php echo $v;?>">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo $v;?>">
    <link rel="stylesheet" type="text/css" href="css/p.css?v=<?php echo $v;?>">
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $v;?>">
    <!-- <script src="https://kit.fontawesome.com/d90d2a7e36.js" crossorigin="anonymous"></script> -->
    <script src="https://kit.fontawesome.com/960d33c629.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <!-- Mobile responsive begins -->
    <div class="side-nav--mobile">
        <div class="dropdownicon">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="side-nav__btn">
            <li class="btn btn__data">
                <a href="/"><i class="fa-solid fa-database"></i> Data</a>
            </li>
            <li class="btn btn__logout">
                <a href="signout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
            </li>
        </div>
    </div>
    <!-- Mobile responsive ends -->
    <div id="admin">
        <div class="side-nav">
            <div class="side-nav__logo">
                <img src="img/code.png">
                <h3><?php echo $title;?></h3>
            </div>
            <div class="side-nav__btn">
                <li class="btn btn__data">
                    <a href="/"><i class="fa-solid fa-database"></i> Data</a>
                </li>
                <li class="btn btn__logout">
                    <a href="signout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
                </li>
            </div>
        </div>
        <div class="function">
            <div class="box notification"></div>
            <div class="file-area">
                <div class="file">
                    <div class="box file__list">
                        <div class="createBtn"><i class="fa-solid fa-plus"></i>  Create file or folder</div>
                        <div class="file__list--ele newFile">
                            <input type="text" placeholder="Enter file or folder path">
                            <button class="accept"><i class="fa-solid fa-check"></i></button>
                            <button class="cancel"><i class="fa-sharp fa-solid fa-xmark"></i></button>
                        </div>
                        <?php
                        function show($path) {
                            $markup = "";
                            $array = scandir($path, SCANDIR_SORT_NONE);
                            if(count($array) == 2) {
                                return;
                            } else {
                                for($i = 0; $i < count($array); $i++) {
                                    if($array[$i] != "." && $array[$i] != ".." && $array[$i] != ".DS_Store") {
                                        $nextPath = $path.DIRECTORY_SEPARATOR.$array[$i];
                                        $img = str_contains($array[$i],".")?end(explode(".", $array[$i])):"folder";
                                        if(is_dir($nextPath)) {
                                            $markup .= '<div style="border-left: solid 2px #000; padding-left: 10px;"><div class="file__list--ele"><div class="img"><img src="/img/'.$img.'.png"></div><p>'.$array[$i].'</p><input type="text" class="edit__box"><button class="edit"><i class="fa-solid fa-pencil"></i><span>edit</span></button><button class="acceptEdit" style="display: none;"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-check"></i></button><button class="delete"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-trash-can"></i><span>remove</span></button></div>'.show($nextPath).'</div>';
                                        } else {
                                            $markup .= '<div style="padding-left: 10px;"><div class="file__list--ele"><div class="img"><img src="/img/'.$img.'.png"></div><p>'.$array[$i].'</p><input type="text" class="edit__box"><button class="edit"><i class="fa-solid fa-pencil"></i><span>edit</span></button><button class="acceptEdit" style="display: none;"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-check"></i></button><button class="delete"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-trash-can"></i><span>remove</span></button><button class="open"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-bars-staggered"></i><span>open</span></button></div></div>';
                                        }
                                    }
                                }
                                return $markup;
                            }
                        }
                        $root = __DIR__.DIRECTORY_SEPARATOR.$product;
                        echo show($root);
                        ?>
                    </div>
                </div>
                <div class="box file__edit">
                    <form id="form-textarea">
                        <input type="text" class="name-open">
                        <textarea form = "form-textarea" id="textarea"></textarea>
                        <div>
                            <button class="commit">Commit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box dist">
                <p>DISTRIBUTION</p>
                <div class="dist__box">
                    <div class="dist__box--func">
                        <input type="text" class="deletePath" placeholder="Enter a path">
                        <textarea class="query"></textarea>
                    </div>
                    <div class="dist__box--list">
                        <form action="" method="GET">
                        <?php
                        if($conn) {
                            $db_list = mysqli_query($conn, "SHOW DATABASES");
                            $i = 1;
                            $prefix = "allincli_".$product."_";
                            while($row = mysqli_fetch_assoc($db_list)) {
                                if(strpos($row['Database'], $prefix) 
                                !== false) {
                                    $storeName = str_replace($prefix,'',$row['Database']);
                                    $domain = str_replace('_','.',$storeName);
                                    echo '<input type="checkbox" class="check" id="'.$storeName.'" value="'.$storeName.'"><label for="'.$storeName.'"> '.$domain.'</label><br>';
                                    $i++;
                                }
                            }
                        } else {
                            echo "Error connecting database: " . mysqli_error($conn);
                        }
                        ?>
                        </form>
                    </div>
                </div>
                <div class="btn">
                    <button class="all">Select All</button>
                    <button class="commit">Commit</button>
                    <button class="send">Send Update Notification</button>
                    <button class="delete">Delete</button>
                    <button class="db">Database</button>
                    <form class="sql" action="data/defaultdb.php">
                        <input type="file" name="sql" hidden>
                        <div>
                            <p>Choose sql</p?>
                        </div>
                        <button name="import">Import</button>
                    </form>
                </div>
            </div>
            <div id="copyright">
            <p><?=$copyright.$phpversion;?></p>
            </div>
        </div>
    </div>
    <script>
        var listOfProduct = <?= json_encode($listOfProduct); ?>;
        const product = "<?=$product;?>";
        let active = ""
        for(const key in listOfProduct[0]) {
            active = (key === product) ? "active" : ""
            $(".side-nav__btn").append(`
            <li class="btn ${active} btn__code">
                <a href="${key}.php">${listOfProduct[1][key]} ${listOfProduct[0][key]}</a>
            </li>
            `)
        }
    </script>
    <script src="js/createFile.js?v=<?=$v;?>"></script>
    <script src="js/edit.js?v=<?=$v;?>"></script>
    <script src="js/delete.js?v=<?=$v;?>"></script>
    <script src="js/open.js?v=<?=$v;?>"></script>
    <script src="js/dist.js?v=<?=$v;?>"></script>
    <script src="js/uploaddb.js?v=<?=$v;?>"></script>
    <script src="js/effect.js?v=<?=$v;?>"></script>
</body>
</html>