<?php

function createUser(array $data = [])
{
    opcache_invalidate('db.php');
    $users = require 'db.php';

    if (empty($data)) {
        $user = $_POST ?? [];
        $error = [];
        if (empty($_POST['name'])){
            $error['name'] = "имя не может быть пустым";
        }
        if (empty($_POST['surname'])){
            $error['surname'] = "фамилия не может быть пустым";
        }
        if (empty($_POST['age']) || $_POST['age'] <1 ){
            $error['age'] = "возраст не корректный";
        }
        if (empty($_POST['email'])){
            $error['email'] = "почта не может быть пустой";
        }
        foreach ($users as $user) {
            $emails[] =  $user['email'];
        }
        if (false !== array_search($_POST['email'], $emails)){
            $error['email'] = "почтовый ящик занят";
        }
        if(!empty($error)){
            return $error;
        }
    } else {
        $user = $data;
    }

    $user['age'] = (int)$user['age'];
    $user['animals'] = $user['animals'] ?? [];
//    $user['animals'] = explode(",", $user['animals']);;
    $user['avatar'] = $user['avatar'] ?? 'https://w0.pngwave.com/png/248/703/evey-hammond-guy-fawkes-mask-v-for-vendetta-v-for-vendetta-png-clip-art.png' ;

    ksort($user);

    $users[] = $user;
    $content = "<?php" .PHP_EOL ."return " ;
    $content = $content . var_export($users, 1);
    $content .= ";";

    file_put_contents('db.php', $content);
}