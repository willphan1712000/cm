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
$listOfProduct = $g['product'];
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
<script defer src="/dist/bundle141fb03bfc58917159ba.js"></script><script defer src="/dist/universald73e00ea6764dab4fcea.js"></script><script defer src="/dist/style7a2e8fb83f4e015c0023.js"></script><script defer src="/dist/responsive6b36ab829f37181435c4.js"></script><script defer src="/dist/p62179af8622905492b2f.js"></script></head>
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
                <a href="/signout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
            </li>
        </div>
    </div>
    <!-- Mobile responsive ends -->
    <div id="admin">
        <div class="side-nav">
            <div class="side-nav__logo">
                <img src="img/code.png" draggable="false">
                <h3><?=$g['title'];?></h3>
            </div>
            <div class="side-nav__btn">
                <li class="btn btn__data">
                    <a href="/"><i class="fa-solid fa-database"></i> Data</a>
                </li>
                <li class="btn btn__logout">
                    <a href="/signout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
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
                        $root = SystemConfig::getRootDir().$product;
                        echo SystemConfig::displayDirectory($root);
                        ?>
                    </div>
                </div>
                <div class="box file__edit">
                    <form id="form-textarea">
                        <input type="text" class="name-open">
                        <textarea form = "form-textarea" id="textarea"></textarea>
                        <div>
                            <button class="commit" disabled>Commit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box dist">
                <p>DISTRIBUTION</p>
                <div class="dist__box">
                    <div class="dist__box--func">
                        <textarea class="query"></textarea>
                    </div>
                    <div class="dist__box--list">
                        <form action="" method="GET">
                        <?php
                        SystemConfig::showListOfWeb($conn, $product);?>
                        </form>
                    </div>
                </div>
                <div class="btn">
                    <button class="all">Select All</button>
                    <button class="commit">Commit</button>
                    <button class="send">Send Update Notification</button>
                    <button class="db">Execute Database</button>
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
            <p><?=$g['copyright'].$g['phpversion'];?></p>
            </div>
        </div>
    </div>
    <script>
        var listOfProduct = <?= json_encode($listOfProduct); ?>;
        const product = "<?=$product;?>";
        const type = "<?=$product;?>";
        let active = ""
        for(const key in listOfProduct[0]) {
            active = (key === product) ? "active" : ""
            $(".side-nav__btn").append(`
            <li class="btn ${active} btn__code">
                <a href="/${key}">${listOfProduct[1][key]} ${listOfProduct[0][key]}</a>
            </li>
            `)
        }
    </script>
</body>
</html>