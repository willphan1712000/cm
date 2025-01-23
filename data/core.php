<?php
class Router {
    private $routes = [];

    function addRoute($uri, $controller) {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    function route($uri) {
        foreach($this->routes as $route) {
            if($route['uri'] === $uri) {
                return require $route['controller'];
            }
        }

        $this->abort();
    }

    private function abort() {
        http_response_code(404);
        require 'dist/notfound.php';
        die();
    }

    function removeLastRoute() {
        array_pop($this->routes);
    }
}

class SystemConfig {
    public static function globalVariables() {
        return [
            'title' => 'Code Management',
            'sessionDuration' => 20*60,
            'v' => self::getVersion(),
            'copyright' => '© '.date("Y").' Allinclicks. All rights reserved. Version: '.self::getVersion(),
            'phpversion' => '. PHP Version: '.phpversion(),
            'product' => [[
                "p" => "Portfolio",
                "vtv" => "VTV",
                "htv" => "HTV"
            ],
            [
                "p" => '<i class="fa-solid fa-image"></i>',
                "vtv" => '<i class="fa-sharp fa-solid fa-tv"></i>',
                "htv" => '<i class="fa-sharp fa-solid fa-tv"></i>'
            ]]
        ];
    }

    public static function getVersion() {
        return 3.21;
    }

    public static function getRootDir() {
        return dirname(__DIR__).DIRECTORY_SEPARATOR."source/";
    }
    
    // dump and die function used for debug process
    public static function dd($value) {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    
        die();
    }
    
    public static function isPassVaild($password) {
        $isLengthValid = false;
        $hasUpperCase = false;
        $hasDigit = false;
        $hasSpecialChar = true; // Bypass special character requirement
        $isLengthValid = (strlen($password) >= 12) ? true : false;
        for($i = 0; $i < strlen($password); $i++) {
            $position = ord($password[$i]); // Get ASCII Value
            if($position >= 65 && $position <= 90) {
                $hasUpperCase = true;
            }
            if($position >= 48 && $position <= 57) {
                $hasDigit = true;
            }
            if($position >= 33 && $position <= 47) {
                $hasSpecialChar = true;
            }
            if($hasUpperCase && $hasDigit && $hasSpecialChar) {
                return true;
            }
        }
    }

    public static function iconClassification($ele) {
        if(str_contains($ele,".")) {
            $img = end(explode(".", $ele));
            $arrOfIcon = ["css", "gif", "html", "ico", "jpeg", "jpg", "js", "json", "md", "mp4", "php", "png", "txt"];
            $has = false;
            foreach($arrOfIcon as $ext) {
                if($img === $ext) {
                    $has = true;
                    break;
                }
                if(str_contains($img, "git")) {
                    $img = "git";
                    $has = true;
                    break;
                }
            }
            if(!$has) {
                $img = "else";
            }
        } else {
            $img = "folder";
        }
        return $img;
    }

    public static function displayDirectory($path) {
        $markup = "";
        $array = scandir($path, SCANDIR_SORT_NONE);
        if(count($array) == 2) {
            return;
        } else {
            for($i = 0; $i < count($array); $i++) {
                if($array[$i] != "." && $array[$i] != ".." && $array[$i] != ".DS_Store") {
                    $nextPath = $path.DIRECTORY_SEPARATOR.$array[$i];
                    $img = self::iconClassification($array[$i]);
                    if(is_dir($nextPath)) {
                        $markup .= '<div style="border-left: solid 2px #000; padding-left: 10px;"><div class="file__list--ele"><div class="img"><img src="/img/'.$img.'.png"></div><p>'.$array[$i].'</p><input type="text" class="edit__box"><button class="edit"><i class="fa-solid fa-pencil"></i><span>edit</span></button><button class="acceptEdit" style="display: none;"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-check"></i></button><button class="delete"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-trash-can"></i><span>remove</span></button></div>'.self::displayDirectory($nextPath).'</div>';
                    } else {
                        $markup .= '<div style="padding-left: 10px;"><div class="file__list--ele"><div class="img"><img src="/img/'.$img.'.png"></div><p>'.$array[$i].'</p><input type="text" class="edit__box"><button class="edit"><i class="fa-solid fa-pencil"></i><span>edit</span></button><button class="acceptEdit" style="display: none;"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-check"></i></button><button class="delete"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-trash-can"></i><span>remove</span></button><button class="open"><input type="hidden" name="'.$nextPath.'"><i class="fa-solid fa-bars-staggered"></i><span>open</span></button></div></div>';
                    }
                }
            }
            return $markup;
        }
    }

    public static function showListOfWeb($conn, $product) {
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
    }
}
class Database {
    private static $servername = "localhost:3306";
    private static $username = "root";
    private static $password = "";
    // private static $username = "allincli_ssadmin";
    // private static $password = "123456"; // Default password used by Allinclicks
    public static function databaseName() {
        return;
    }
    public static function connection() {
        return mysqli_connect(self::$servername, self::$username, self::$password);
    }
    public static function getDatabaseInfo() {
        return [self::$servername, self::$username, self::$password];
    }
}

function distDelete($path, $exception) {
    if(!is_dir($path)) {
        if(!unlink($path)){
            return "Could not delete this file ".$path;
        }
    } else {
        $all1 = glob($path."*", GLOB_MARK);
        $all2 = glob($path.".*", GLOB_MARK);
        $all = array_merge($all1, $all2);
        foreach($all as $a) {
            $ff = basename($a);
            if($ff === ".") continue;
            if($ff === "..") continue;
            if(in_array($a, $exception)) continue;
            distDelete($a, $exception);
        }
        rmdir($path);
    }
    return "Delete success";
}

function copyfolder($from, $to) {
    // Check original folder
    if(!is_dir($from)) {
        exit("$from does not exist");
    }
    // // Check the destination folder, if not exist, create one
    if(!is_dir($to)) {
        if(!mkdir($to)) {
            exit("Failed to create $to");
        }
    }
    // Get all files and folders in source
    $all1 = glob("$from*", GLOB_MARK);
    $all2 = glob("$from.*", GLOB_MARK);
    $all = array_merge($all1, $all2);
    // Copy files + Recursive Internal Folders
    if(count($all) > 0) {
        foreach($all as $a) {
            $ff = basename($a); // Get current file, folder name
            if($ff === ".") continue;
            if($ff === "..") continue;
            if($ff === ".DS_Store") continue;
            if(is_dir($a)) {
                copyfolder("$from$ff/","$to$ff/");
            } else {
                if(!copy($a, "$to$ff")) {
                    exit("Error of copying");
                }
            }
        }
    }
}
?>