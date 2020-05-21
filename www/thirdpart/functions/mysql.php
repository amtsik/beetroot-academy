<?php
//phpinfo();
//die();
//$con->close();

if (!empty($_GET['idBook'])){
    $query = "
SELECT message
FROM `bookstore`.`commet`
where `bookstore`.`commet`.`book_id` = " .$_GET['idBook'];

    $result = getPDO();
    $comments = [];

    foreach ($result as $row) {
        $comments[] = $row;
    }
    header("Location: /thirdpart/index.php#".$_GET['idBook']);
}
//print_r($books);

function getPDO () {
    $dbHost="192.168.99.100:3308";
//$dbPort=3308;
    $dbUser="fs_user";
    $dbPassword="1234";
    $dbName="bookstore";
    $dbDns = "mysql:dbname=$dbName;host=$dbHost;charset=utf8mb4";
    try {
        $pdo = new  PDO ($dbDns, $dbUser, $dbPassword);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
    catch(PDOException $e)
    {
        die( "Connection failed: " . $e->getMessage());
    }
}

function getBooks() : array
{
    $query = '
select b.id \'idBook\', b.title \'titleBook\', a.name \'authorBook\', g.name \'genreBook\', IFNULL(c.rating, \'0\') \'commetRating\'  from bookstore.book b
join bookstore.author a on a.id = b.author_id
join genre g on g.id = b.genre_id
left join commet c on c.comment_id = b.id;
';
    $pdo = getPDO();
    $result = $pdo -> query($query);
//    $books = [];
//
//    foreach ($result as $row) {
//        $books[] = $row;
//    }
//    вместо этого можно использовать -> fetch() возращает первую запись выборки
//    hetchAll - сделает массив из записей
//    return $books;
    return $result ->fetchAll(PDO::FETCH_ASSOC);
}

function sendQuery (string $query, array $execute )
{
    $pdo = getPDO();

    try {
        $result = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $result = $pdo -> prepare($query);
        $result->execute($execute);
        return $result;
    }
    catch (PDOException $e) {
        header("Location: /thirdpart/index.php");
    }
}

function getBooksByID($bookId) : array
{
    $bookId = htmlspecialchars($bookId);
    $query = "
select b.id 'idBook', b.title 'titleBook', a.name 'authorBook', g.name 'genreBook', g.id 'genreBookId', AVG(IFNULL(c.rating, '0')) 'commetRating'  from bookstore.book b
join bookstore.author a on a.id = b.author_id
join genre g on g.id = b.genre_id
left join commet c on c.book_id = b.id
where b.id =  ? ;";

    return sendQuery($query, [$bookId])->fetch(PDO::FETCH_ASSOC);
}

function getBookComment($bookId) : array
{
    $bookId = htmlspecialchars($bookId);
    $query = "
SELECT message, rating
FROM `bookstore`.`commet`
where `bookstore`.`commet`.`book_id` = ?
;";
//    var_dump(sendQuery($query, [$bookId])->fetch(PDO::FETCH_ASSOC));
    $result = sendQuery($query, [$bookId]);
    if (!is_array($result))
    {
        return $result->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return ['пользователи еще не оставили комментарии'];
    }
}

function getGenres() : array
{
    $query = "
SELECT name, id 
FROM `bookstore`.`genre`
;";
    return sendQuery($query, [])->fetchALL(PDO::FETCH_ASSOC);
}

