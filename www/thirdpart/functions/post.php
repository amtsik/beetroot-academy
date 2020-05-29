<?php
require 'mysql.php';

//записываем коммернтарии в базу
if (!empty($_POST['book_id']) && !empty($_POST['comment'])) {
    addComment($_POST['comment'], $_POST['book_id']);
    header("Location: ../page.php?book_id=" . $_POST['book_id']);
}

//записываем в куки количество купленных книг
if (!empty($_POST['book_id']) && !empty($_POST['count'])) {
    addToCard($_POST['book_id'], $_POST['count']);
    header("Location: ../page.php?book_id=" . $_POST['book_id']);
}

//записываем в куки количество купленных книг
if (!empty($_POST['Checkout'])) {
    createOrder();
    header("Location: ../cart.php");
}

//изменяем количество книг в корзине
if (!empty($_POST['glyphicon'])) {
    var_dump($_POST);
    removeItemFromCount($_POST['glyphicon']);
//    die();
    header("Location: ../cart.php");
}