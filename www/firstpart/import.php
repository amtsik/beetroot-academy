<?php

require 'createUser.php';
//require 'functions.php';

$users = require_once 'db.php';

if (!empty($_FILES)){

    $source = $_FILES['import']['tmp_name'];
    $fileName = $_FILES['import']['name'];
    $dest = "./tmp" .$fileName;
    move_uploaded_file($source, $dest);
    $handle = fopen($dest, 'r');
    $headers = fgetcsv($handle);
    $emails = array_column($users, 'email');
    while (!feof($handle)){
        $row = fgetcsv($handle);
        if (!empty($row)){
            $user = array_combine($headers, $row);
            if (false === array_search($user['email'], $emails)){
                createUser($user);
            }
        }
    }
    header('location: /stats.php?import=ok');
}