<?php
require 'core.php';
$conn = Database::connection();
[$server, $username, $password] = Database::getDatabaseInfo();
$from = "../source/".$_POST['product']."/";
$to = "../../";
$data = $_POST['data'];
$data = json_decode($data);

foreach($data as $key => $value) {
    $folderName = str_replace('_','.',$value);
    distDelete($to.$folderName."/", [$to.$folderName."/upload/", $to.$folderName."/img/logo/"]);
    copyfolder($from, $to.$folderName."/");
}
// foreach($data as $key => $value) {
//     // Below is to update tech files
//     $folderName = str_replace('_','.',$value);
//     $pathToTech = $to.$folderName."/admin/tech/";
//     if(file_exists($pathToTech)) {
//         $conn = mysqli_connect($server,$username,$password, "allincli_p_".$value);
//         if(!$conn) {
//             exit("Can not connect to database");
//         } else {
//             $tech = mysqli_query($conn,"SELECT id FROM tech");
//             while ($row = mysqli_fetch_array($tech)) {
//                 $techIndex = file_get_contents($pathToTech.'techIndex.txt');
//                 $techAdmin = file_get_contents($pathToTech.'adminTech/techAdmin.txt');
//                 $techAdminIndex = file_get_contents($pathToTech.'adminTech/techAdminIndex.txt');
//                 $techIndexPhp = fopen($pathToTech.$row['id'].".php","w");
//                 $techAdminPhp = fopen($pathToTech."adminTech/".$row['id'].".php", "w");
//                 $techAdminIndexPhp = fopen($pathToTech."adminTech/index_".$row['id'].".php", "w");
//                 fwrite($techIndexPhp, $techIndex);
//                 fwrite($techAdminPhp, $techAdmin);
//                 fwrite($techAdminIndexPhp, $techAdminIndex);
//                 fclose($techIndexPhp);
//                 fclose($techAdminPhp);
//                 fclose($techAdminIndexPhp);
//             }
//         }
//     }
// }
