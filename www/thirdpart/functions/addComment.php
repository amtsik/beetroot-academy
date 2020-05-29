<?php
require_once 'mysql.php';

if (!empty($_GET['book_id']) &&!empty($_GET['comment'])) {
    addComment($_GET['comment'], $_GET['book_id']);
}
