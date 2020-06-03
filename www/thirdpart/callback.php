<?php
require "./functions/mysql.php";

//var_dump(base64_decode($_POST['data']));

session_start([
    'cookie_lifetime' => 86400,
    'cookie_httponly' => true
]);
//var_dump($_SESSION);
//var_dump(SID);
//die();
updateOrder ($_POST['data']);
header("Location: ../index.php" );
//var_dump($_SESSION);
//getPaymentStationMessage();

die();