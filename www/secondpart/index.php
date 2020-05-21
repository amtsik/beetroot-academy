<?php

//echo exec('whoami') .PHP_EOL;
//echo "<br>";
//die();

//phpinfo(); exit;
require 'functions.php';

$items = loadAll();
//$xml = loadRss('https://dumskaya.net/rssnews/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h3>Новости Украины</h3>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link" href="?limit=5">6</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?limit=10">10</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">Все</a>
        </li>
    </ul>
    <ol>
        <?php foreach ($items as $key => $article) : ?>
            <div class="card" style="width: 16rem;float:left">
                <img class="card-img-top" src="<?=$article->image ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?=$article->title ?></h5>
                    <p class="card-text"><?=$article->description ?></p>
                    <a href="<?=$article->title ?>" class="btn btn-primary"><?=$article->title ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </ol>
</div>
</body>
</html>