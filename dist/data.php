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
$listOfProduct = $g['product'];
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
<script defer src="/dist/main539f340cbcd814e8ae49.js"></script><script defer src="/dist/universal3822cbb87a5a56f60e2c.js"></script><script defer src="/dist/style4ca2fd3a6f68b579cfa1.js"></script><script defer src="/dist/p4fa0ea8126a9853172ce.js"></script><script defer src="/dist/responsive85a42f4d516c9a121a3d.js"></script></head>
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
                <li class="btn active btn__data">
                    <a href="/"><i class="fa-solid fa-database"></i> Data</a>
                </li>
                <li class="btn btn__logout">
                    <a href="/signout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a>
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
                <p><?=$g['copyright'].$g['phpversion'];?></p>
            </div>
        </div>
    </div>

    <script>
        var listOfProduct = <?= json_encode($listOfProduct); ?>;
        const type = "stats";
        for(const key in listOfProduct[0]) {
            $(".side-nav__btn").append(`
            <li class="btn btn__code">
                <a href="${key}">${listOfProduct[1][key]} ${listOfProduct[0][key]}</a>
            </li>
            `)
        }
    </script>
</body>
</html>