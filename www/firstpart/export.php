<?php
$users = require_once 'db.php';

$exportFileName = "./tmp/export.scv";

$file = fopen($exportFileName, 'w');

fputcsv($file, array_keys(current($users)));

foreach ($users as $user) {
    $user['animals'] = implode(',', $user['animals']);
    fputcsv($file, $user);
}

fclose ($file);

header('Content-Disposition: attachment; filename="filename.csv"');

echo file_get_contents($exportFileName);