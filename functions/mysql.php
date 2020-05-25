<?php
//phpinfo();
//die();
//$con->close();
//print_r($books);

define('ITEMS_PER_PAGE', 8);

function getPDO () {
    $dbHost="127.0.0.1:3306";
    $dbUser="root";
    $dbPassword="";
//    $dbPassword="root";
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
    $page = getPageNumber();
    $offset = ($page - 1 ) * ITEMS_PER_PAGE;
    $query = "
select b.id 'idBook', b.title 'titleBook', a.name 'authorBook', g.name 'genreBook', IFNULL(c.rating, '0') 'commentRating'  from `bookstore`.`book` b
join bookstore.author a on a.id = b.author_id
join genre g on g.id = b.genre_id
left join comment c on c.comment_id = b.id
LIMIT $offset, " .ITEMS_PER_PAGE .";"
    ;
//    var_dump($query);
//    die();

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
select b.id 'idBook', b.title 'titleBook', a.name 'authorBook', g.name 'genreBook', g.id 'genreBookId', AVG(IFNULL(c.rating, '0')) 'commentRating'  from bookstore.book b
join bookstore.author a on a.id = b.author_id
join genre g on g.id = b.genre_id
left join comment c on c.book_id = b.id
where b.id =  ? ;
";

    return sendQuery($query, [$bookId])->fetch(PDO::FETCH_ASSOC);
}

function getBookComment($bookId) : array
{
    $bookId = htmlspecialchars($bookId);
    $query = "
SELECT *
FROM `bookstore`.`comment`
where `bookstore`.`comment`.`book_id` = ?;
";
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
SELECT * 
FROM `bookstore`.`genre`;
";
    return sendQuery($query, [])->fetchALL(PDO::FETCH_ASSOC);
}

function addComment ($comment, $bookId)
{
    $comment = htmlspecialchars($comment);
    $sql = "INSERT INTO `comment` (message, book_id) VALUE (:comment, :book);";
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt -> execute ([
        'comment' => $comment,
        'book'    => $bookId
    ]);
}

function formatCommentDate (string $date) : string
{
    $time = strtotime($date);
    return date('n/j/y', $time);
}


function paginate()
{
    $endPost = $startPost = $page = getPageNumber();
    $pageCount = getTotal();
    $buttons ="";

    for ($i = 0 ; $i < 2 ; $i++) {
        if ($startPost === 1) {
            break;
        }
        $startPost--;
    }

    for ($i = 0 ; $i < 2 ; $i++) {
        if ($endPost === $pageCount) {
            break;
        }
        $endPost++;
    }

    for ($i = $startPost; $i <= $endPost; $i++ ){
        $active = $page === $i ? 'active' : '';
        $buttons .= "<li class=\"page-item $active\"><a class=\"page-link\" href=\"?page=$i\">$i</a></li>";
    }


    return <<<PAGINATION
<nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            
            $buttons
            
            <li class="page-item">
                <a class="page-link" href="?page=$pageCount" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
PAGINATION;

}

function getPageNumber () : int
{
    $page = $_GET['page'] ?? 1;
    $total = getTotal();
    if ( $page < 1) {
        $page = 1;
    } elseif ( $page > $total ) {
        $page = $total;
    }
    return (int)$page;
}

function getTotal () : int
{

    static $count;
    if ($count === null) {
        $sql = 'SELECT COUNT(1) FROM book;';
        $pdo = getPDO();
        $stmt = $pdo->query($sql);
        $count = $stmt->fetch(PDO::FETCH_COLUMN);
        $count = ceil($count / ITEMS_PER_PAGE);
        return $count;
    }
    return $count;
}