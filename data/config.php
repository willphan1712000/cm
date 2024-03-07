<?php
$server = "localhost:3306";
$username = "root";
$password = "";

// $allincli_codemanagement = mysqli_connect("localhost:3306","root","") or die(mysqli_error());
// mysqli_select_db($allincli_codemanagement,'allincli_codemanagement') or die(mysqli_error());

// When deploying web app, change connection information
// $server = "localhost:3306";
// $username = "allincli_ssadmin";
// $password = "123456";
// $dbname = whatever it is
$conn = mysqli_connect($server,$username,$password) or die(mysqli_error());