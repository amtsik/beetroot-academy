<?php
require 'mysql.php';

if (!empty($_POST['book_id']) &&!empty($_POST['comment'])) {
    addComment($_POST['comment'], $_POST['book_id']);
    header("Location: ../page.php?book_id=" .$_POST['book_id']);
}