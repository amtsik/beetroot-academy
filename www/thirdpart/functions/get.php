<?php


//if (!empty($_GET['idBook'])){
//    $query = "
//SELECT message
//FROM `bookstore`.`comment`
//where `bookstore`.`comment`.`book_id` = " .$_GET['idBook'] .";";
//
//    $result = getPDO();
//    $comments = [];
//
//    foreach ($result as $row) {
//        $comments[] = $row;
//    }
//    header("Location: ../index.php#".$_GET['idBook']);
//}

if (!empty($_GET['book_id'])) {
    $book = getBooksByID($_GET['book_id']);
    $comments = getBookComment($_GET['book_id']);
//    var_dump($comments);
//    die();
}
else {
    header("Location: index.php");
}