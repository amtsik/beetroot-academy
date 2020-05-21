<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

$assoc = [
    'name' => "",
    'surname' => "",
    'age' => "",
    'email' => "",
    'gender' => [],
    'animals' => [],
];


if (!empty($_GET)) {
    $error = $_GET['error'] ?? [];
}
//die('no post');

$lang = (!empty($_GET['lang'])) ? $_GET['lang'] : "ru";

$labels = [
    'ru' => [
        'name' => 'имя',
        'surname' => 'фамилия',
        'age' => 'возраст',
        'email' => 'почта',
        'gender' => [
            'name' =>'пол',
            'list' => ['не определена', 'мужской', 'женский'],
        ],
        'animals' => [
            'name'=>'животные',
            'list' => [
                'dog' => 'собака',
                'cat' => 'кошка',
                'parrot' => 'попугай',
                'horse' => 'лошадь'
            ]
        ],
    ],
    'ua' => [
        'name' => 'им\'я',
        'surname' => 'фамилия',
        'age' => 'вiк',
        'email' => 'почта',
        'gender' => [
            'name' =>'стать',
            'list' => ['невідома', 'чоловича', 'жиноча'],
        ],
        'animals' => [
            'name'=>'животные',
            'list' => [
                'dog' => 'собако',
                'cat' => 'кішка',
                'parrot' => 'попуга',
                'horse' => 'кінь'
            ]
        ],
    ],
    'en' => [
        'name' => 'name',
        'surname' => 'surname',
        'age' => 'age',
        'email' => 'email',
        'gender' => [
            'name' =>'gender',
            'list' => ['undefine', 'male', 'female'],
        ],
        'animals' => [
            'name'=>'animals',
            'list' => [
                'dog' => 'dog',
                'cat' => 'cat',
                'parrot' => 'parrot',
                'horse' => 'horse'
            ]
        ],
    ],
];

switch ($lang){
    case 'ua':
        $translation = $labels['ua'];
        break;
    case 'en':
        $translation = $labels['en'];
        break;
    default:
        $translation = $labels['ru'];
        break;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" >
</head>
<body>
<br />
<div class="container">
    <h3 hidden style="color: red"><?=implode("<br />", $error)?></h3>
    <form method="post" action="stats.php">
        <div class="float-right">
            <a href="?lang=ru" class="badge badge-primary">Русский</a>
            <a href="?lang=ua" class="badge badge-secondary">Украинский</a>
            <a href="?lang=en" class="badge badge-success">Английский</a>
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Example label</label>
            <div class="">
                <label for=""><?= $translation['name']?></label>
                <input type="text" class="form-control" id="formGroupNameInput" placeholder="<?=$assoc['name']?>" value="<?=$_POST['name'] ?? "" ?>" name="name">
                <?php if (!empty($error['name'])) : ?>
                    <small id="passwordHelpInline1" class="text-muted">
                        <?=$error['name'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="">
                <label for=""><?= $translation['surname']?></label>
                <input type="text" class="form-control" id="formGroupSurnameInput" placeholder="<?=$assoc['surname']?>" value="<?= $_POST['surname'] ?? "" ?>" name="surname">
                <?php if (!empty($error['surname'])) : ?>
                    <small id="passwordHelpInline2" class="text-muted">
                        <?=$error['surname'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="">
                <label for=""><?= $translation['age']?></label>
                <input type="text" class="form-control" id="formGroupAGEInput" placeholder="<?=$assoc['age']?>" value="<?= $_POST['age'] ?? "" ?>" name="age">
                <?php if (!empty($error['age'])) : ?>
                    <small id="passwordHelpInline" class="text-muted">
                        <?=$error['age'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="">
                <label for=""><?= $translation['email']?></label>
                <input type="email" class="form-control" id="formGroupMailInput" placeholder="<?=$assoc['email']?>" value="<?= $_POST['email'] ?? "" ?>" name="email">
                <?php if (!empty($error['email'])) : ?>
                    <small id="passwordHelpInline" class="text-muted">
                        <?=$error['email'] ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1"><?= $translation['gender']['name']?></label>
                <select class="form-control" id="exampleFormControlSelect1" name="gender" >
                    <option  value="undef" selected ><?= $translation['gender']['list'][0]?></option>
                    <option  value="male" ><?= $translation['gender']['list'][1]?></option>
                    <option  value="female" ><?= $translation['gender']['list'][2]?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1"><?= $translation['animals']['name']?></label>
                <select multiple class="form-control" id="exampleFormControlSelect2" name="animals[]" >
                    <?php
                    foreach ($translation['animals']['list'] as $key => $value){
                        echo "<option  value=\""
                            .$key
                            ."\""
                            .">"
                            .$value
                            ."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
</body>
</html>
