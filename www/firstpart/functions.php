<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

opcache_invalidate('db.php');
$users = require 'db.php';

require_once './createUser.php';

function sortFields($userA, $userB)
{
    if (!empty($_GET['order']) && $_GET['order'] === 'asc') {
        return $userA[$_GET['sort']] <=> $userB[$_GET['sort']];
    }
    return $userB[$_GET['sort']] <=> $userA[$_GET['sort']];
}

function filterAnimals(array $users) : array
{
    $animals =[];
    foreach ($users as $user){
        $animals = array_merge($animals, $user['animals']);
    }
    sort($animals, SORT_STRING|SORT_NATURAL);
    $animals = array_filter($animals, function($element) {
        return !empty($element);
    });

    return array_unique($animals);
}

if (!empty($_POST)){
    $err = createUser();
    if (!empty($err)) {
        foreach ($err as $key => $message) {
            $errorString .= "error[$key]=$message&";
        }
        header('Location: ./user.php?' .$errorString);
    }
    opcache_invalidate('db.php');
    $users = require 'db.php';
}

if (!empty($_GET['sort'])){
    switch ($_GET['sort']) {
        case 'id':
            if (!empty($_GET['order']) && $_GET['order'] == 'desk') {
                krsort($users);
            } else {
                ksort($users);
            }
            $users = array_values($users);
            break;
        case 'name':
            usort ($users, 'sortFields');
            break;
        case 'surname':
        case 'age':
        case 'gender':
            usort ($users, 'sortFields');
            break;
    }
}

if (!empty($_GET) && !empty($_GET['filter'])){
    switch ($_GET['filter']) {
        case 'man':
            foreach ($users as $key => $user) {
                if ($user['gender'] !== 'man') {
                    unset($users[$key]);
                }
            }
            break;
        case 'woman':
            foreach ($users as $key => $user) {
                if ($user['gender'] !== 'woman') {
                    unset($users[$key]);
                }
            }
            break;
        case 'covid':
            foreach ($users as $key => $user) {
                if ((int)$user['age'] <= 60) {
                    unset($users[$key]);
                }
            }
            break;
        default :
            break;
    }
}

if (!empty($_GET) && !empty($_GET['filter2'])){

    foreach ($users as $usersKey => $user) {
        if ( is_bool(array_search($_GET['filter2'], $user['animals'])) ){
            unset($users[$usersKey]);
        }
    }

}
