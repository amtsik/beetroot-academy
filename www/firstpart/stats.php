<?php

require './functions.php';

$animals = filterAnimals($users);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" >
</head>
<body>
<div class="container">

    <nav class="navbar navbar-light bg-light ">
        <a class="navbar-brand" href="export.php">экспорт</a>
        <form class="form-inline input-group" action="import.php" method="POST"  enctype="multipart/form-data">
            <div class="custom-file">
                <input class="custom-file-input" name="import" type="file">
                <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
            </div>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" >загрузить</button>
            </div>
        </form>
    </nav>

    <div class="p"><br><br><br></div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col"><a href="?sort=id<?='&order=' .(!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk')?>">#</a></th>
            <th scope="col" value="name">
                <a href="?sort=name&order=<?= !empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk' ?>">name</a>
            </th>
            <th scope="col" value="surname">
                <a href="?sort=surname&order=<?= (!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk') ?>">surname</a>
            </th>
            <th scope="col" value="age">
                <a href="?sort=age&order=<?= (!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk') ?>">age</a>
            </th>
            <th scope="col" value="gender">
                <a href="?sort=gender&order=<?= (!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk') ?>">gender</a>
            </th>
            <th scope="col" value="email">
                <a href="?sort=email&order=<?= (!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk') ?>">email</a>
            </th>
            <th scope="col" style="pointer-events: none" value="avatar">
                <a href="?sort=avatar&order=<?= (!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk') ?>">avatar</a>
            </th>
            <th scope="col" style="pointer-events: none" value="animals">
                <a href="?sort=animals&order=<?= (!empty($_GET['order']) && $_GET['order'] === 'desk' ? 'asc' : 'desk') ?>">animals</a>
            </th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $key => $value) :?>
                <?php $id = !empty($_GET['order']) && $_GET['order'] == 'asc' ? count($users) - $key : $key + 1 ; ?>
                <tr style="background-color: <?= ($key%2 ===0 ? '#aaa' : '#fff') ?> ">
                    <th scope="row"> <?= $key + 1 ?> </th>
                    <th scope="row"> <?= $value['name'] ?> </th>
                    <th scope="row"> <?= $value['surname'] ?> </th>
                    <th scope="row"> <?= $value['age'] ?> </th>
                    <th scope="row"> <?= $value['gender'] ?> </th>
                    <th scope="row"> <?= $value['email'] ?> </th>
                    <th scope="row"><img src="<?= $value['avatar'] ?? "" ?>" class="mx-auto" alt="..." style="height: 5rem;"></th>
                    <th scope="row">
                        <ul>
                            <?php foreach ($value['animals'] as $key => $value): ?>
                                <?= $value ? "<li>$value</li>" : ""?>
                            <?php endforeach; ?>
                        </ul>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="" method="get">
        <select name="filter" id="">
            <option value=""></option>
            <option value="man"<?= (!empty($_GET['filter']) && $_GET['filter'] == 'man') ? ' selected' : '' ?> >Мужчины</option>
            <option value="woman" <?= (!empty($_GET['filter']) && $_GET['filter'] == 'woman') ? ' selected' : '' ?> >Женцины</option>
            <option value="covid" <?= (!empty($_GET['filter']) && $_GET['filter'] == 'covid') ? ' selected' : '' ?> >Риск COVID AGE > 60</option>
        </select>

        <select name="filter2" id="">
            <option value=""></option>
            <?php foreach ($animals as $key => $value): ?>
                <option value="<?= $value ?>" <?= (!empty($_GET['filter2']) && $_GET['filter2'] == $value) ? ' selected' : '' ?> ><?= $value ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit">
    </form>

    <a href="/user.php">на страницу регистрации</a>
</div>
</body>
</html>



