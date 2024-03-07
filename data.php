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
    <link rel="stylesheet" type="text/css" href="css/responsive.css?v=<?php echo $v;?>">
    <script src="https://kit.fontawesome.com/d90d2a7e36.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <!-- Mobile responsive begins -->
    <div class="side-nav--mobile">
        <div class="dropdownicon">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="side-nav__btn">
            <li class="btn active btn__data">
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
                <h3><?php echo $title; ?></h3>
            </div>
            <div class="side-nav__btn">
                <li class="btn active btn__data">
                    <a href="/"><i class="fa-solid fa-database"></i> Data</a>
                </li>
                <li class="btn btn__logout">
                    <a href="signout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
                </li>
            </div>
        </div>
        <div class="function">
            <div class="stats">
                <div id="p" class="product-category">
                    <i class="fa-solid fa-briefcase"></i>
                    <div class="box count">
                        <div class="count__icon">
                        <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of Portfolio</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                    <div class="box mimg-count">
                        <div class="count__icon">
                        <i class="fa-solid fa-image"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of updated mobile photos</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                    <div class="box tvimg-count">
                        <div class="count__icon">
                        <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of uploaded TV photos</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                </div>
    
                <div id="vtv" class="product-category">
                    <i class="fa-solid fa-tv"></i>
                    <div class="box count">
                        <div class="count__icon">
                        <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of TV</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                    <div class="box tvimg-count">
                        <div class="count__icon">
                        <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of uploaded TV photos</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                </div>

                <div id="htv" class="product-category">
                    <i class="fa-solid fa-tv"></i>
                    <div class="box count">
                        <div class="count__icon">
                        <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of TV</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                    <div class="box tvimg-count">
                        <div class="count__icon">
                        <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="count__text">
                            <h4>Number of uploaded TV photos</h4>
                            <div class="spinner"></div>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box search p">
                <div class="search__box">
                    <form action="">
                        <input type="text" placeholder = "search">
                    </form>
                </div>
                <div class="search__result">
                    <div class="spinner"></div>
                    <table></table>
                </div>
            </div>

            <div class="box search vtv">
                <div class="search__box">
                    <form action="">
                        <input type="text" placeholder = "search">
                    </form>
                </div>
                <div class="search__result">
                    <div class="spinner"></div>
                    <table></table>
                </div>
            </div>

            <div class="box search htv">
                <div class="search__box">
                    <form action="">
                        <input type="text" placeholder = "search">
                    </form>
                </div>
                <div class="search__result">
                    <div class="spinner"></div>
                    <table></table>
                </div>
            </div>

            <div id="copyright">
                <p><?=$copyright.$phpversion;?></p>
            </div>
        </div>
    </div>

    <script>
        var listOfProduct = <?= json_encode($listOfProduct); ?>;
        var product = "<?=$product;?>";
        for(const key in listOfProduct[0]) {
            $(".side-nav__btn").append(`
            <li class="btn btn__code">
                <a href="${key}.php">${listOfProduct[1][key]} ${listOfProduct[0][key]}</a>
            </li>
            `)
        }
    </script>
    <script src="js/effect.js?v=<?=$v;?>"></script>
    <script src="js/stats.js?v=<?=$v;?>"></script>
    <script src="js/search.js?v=<?=$v;?>"></script>
</body>
</html>