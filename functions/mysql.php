<?php
//phpinfo();
//die();
//$con->close();
//print_r($books);

define('ITEMS_PER_PAGE', 8);
define('PUBLIC_KEY', 'sandbox_i56764552875');
define('PRIVATE_KEY', 'sandbox_tBs1GjaECEnqhQO6ERo6UhHOT8c2fwRlUFiFtaKl');

function getPDO()
{
    $dbHost = "127.0.0.1:3306";
    $dbUser = "root";
    $dbPassword = "";
//    $dbPassword="root";
    $dbName = "bookstore";
    $dbDns = "mysql:dbname=$dbName;host=$dbHost;charset=utf8mb4";
    try {
        $pdo = new  PDO ($dbDns, $dbUser, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: ".$e->getMessage());
    }
}

function getBooks(array $ids = [], int $itemsPerPage = ITEMS_PER_PAGE): array
{
    $page = getPageNumber();
    $offset = ($page - 1) * ITEMS_PER_PAGE;
    $query = "
        select b.id 'idBook', b.title 'titleBook', b.coast 'coastBook', a.name 'authorBook', g.name 'genreBook', IFNULL(c.rating, '0') 'commentRating'  from `bookstore`.`book` b
        join bookstore.author a on a.id = b.author_id
        join genre g on g.id = b.genre_id
        left join comment c on c.comment_id = b.id
        %s
        ORDER BY b.title LIMIT $offset, ".$itemsPerPage.";";

    $where = '';

    if (!empty($ids)) {
        $where = sprintf('where b.id IN (%s)', implode(',', $ids));
    }

    $query = sprintf($query, $where);
    $pdo = getPDO();
    $result = $pdo->query($query);
//    $books = [];
//
//    foreach ($result as $row) {
//        $books[] = $row;
//    }
//    вместо этого можно использовать -> fetch() возращает первую запись выборки
//    hetchAll - сделает массив из записей
//    return $books;
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function sendQuery(string $query, array $execute)
{
    $pdo = getPDO();

    try {
        $result = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $result = $pdo->prepare($query);
        $result->execute($execute);

        return $result;
    } catch (PDOException $e) {
        header("Location: /thirdpart/index.php");
    }
}

function getBooksByID($bookId): array
{
    $bookId = htmlspecialchars($bookId);
    $query = "
        select b.id 'idBook', b.title 'titleBook', b.coast 'coastBook', a.name 'authorBook', g.name 'genreBook', g.id 'genreBookId', AVG(IFNULL(c.rating, '0')) 'commentRating'  from bookstore.book b
        join bookstore.author a on a.id = b.author_id
        join genre g on g.id = b.genre_id
        left join comment c on c.book_id = b.id
        where b.id =  ? ;
";

    return sendQuery($query, [$bookId])->fetch(PDO::FETCH_ASSOC);
}

function getBookComment($bookId): array
{
    $bookId = htmlspecialchars($bookId);
    $query = "
SELECT *
FROM `bookstore`.`comment`
where `bookstore`.`comment`.`book_id` = ?;
";
//    var_dump(sendQuery($query, [$bookId])->fetch(PDO::FETCH_ASSOC));
    $result = sendQuery($query, [$bookId]);
    if (!is_array($result)) {
        return $result->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return ['пользователи еще не оставили комментарии'];
    }
}

function getGenres(): array
{
    $query = "
SELECT * 
FROM `bookstore`.`genre`;
";

    return sendQuery($query, [])->fetchALL(PDO::FETCH_ASSOC);
}

function addComment($comment, $bookId)
{
    $comment = htmlspecialchars($comment);
    $sql = "INSERT INTO `comment` (message, book_id) VALUE (:comment, :book);";
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [
            'comment' => $comment,
            'book' => $bookId,
        ]
    );
}

function formatCommentDate(string $date): string
{
    $time = strtotime($date);

    return date('n/j/y', $time);
}


function paginate()
{
    $endPost = $startPost = $page = getPageNumber();
    $pageCount = getTotal();
    $buttons = "";

    for ($i = 0; $i < 2; $i++) {
        if ($startPost === 1) {
            break;
        }
        $startPost--;
    }

    for ($i = 0; $i < 2; $i++) {
        if ($endPost === $pageCount) {
            break;
        }
        $endPost++;
    }

    for ($i = $startPost; $i <= $endPost; $i++) {
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

function getPageNumber(): int
{
    $page = $_GET['page'] ?? 1;
    $total = getTotal();
    if ($page < 1) {
        $page = 1;
    } elseif ($page > $total) {
        $page = $total;
    }

    return (int)$page;
}

/**
 *
 * get total pages for pagination
 *
 * @return int
 */
function getTotal(): int
{

    static $count;
    if ($count === null) {
        $count = getBooksCount ();
        $count = ceil($count / ITEMS_PER_PAGE);
        return $count;
    }

    return $count;
}

/**
 *
 * get books count
 *
 * @return int
 */
function getBooksCount () : int
{
    static $count;
    if ($count === null ) {
        $query = 'SELECT COUNT(*) FROM bookstore.book;';
        $pdo = getPDO();
        $count = $pdo->query($query);
        $count = $count -> fetch(PDO::FETCH_COLUMN);
    }
    return (int)$count;
}


/**
 * add to card
 * set cookie files
 *
 * @param $bookId
 * @param  int  $count
 */

function addToCard($bookId, int $count)
{
    $cart = [];
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
    }

    if (!isset($_COOKIE['cart'])) {
        $cart[$bookId] = 0;
    }

    $cart[$bookId] += $count;
    setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 365, '/');
}

/**
 *
 * get items count from cookies file
 *
 * @return int
 */
function getItemsCount(): int
{
    static $total;
    if ($total === null) {
        $total = 0;
        if (!empty($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart'], true);
            foreach ($cart as $count) {
                $total += $count;
            }
        }
    }
    return (int)$total;
}

/**
 *
 * remove item from count
 *
 * @param  int  $glyphicon
 */
function removeItemFromCount(int $glyphicon)
{
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
        setcookie('cart', json_encode($cart), time() -100, '/');
        unset($cart[$glyphicon]);
        setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 365, '/');
    }
}

/**
 *
 * get cart items
 *
 * @return array|string[][]
 */
function getCartItms(): array
{

    if ( isset($_COOKIE['cart']) && count(json_decode($_COOKIE['cart'], true)) > 0 ) {
        $cart = json_decode($_COOKIE['cart'], true);
        $ids = array_keys($cart);
        $books =getBooks($ids, getBooksCount());
        foreach ($books as &$book) {
            $book['count'] = $cart[ $book['idBook'] ];
        }
        return $books;
    }
    return [];
}


/**
 * create order with book
 *
 * @return int
 */
function createOrder(): int
{
    static $orderId;
    if ($orderId === null) {
        $items = getCartItms();
        $sql = 'INSERT INTO `order` VALUES ()';
        $pdo = getPDO();
        $pdo->query($sql);
        $orderId = $pdo->lastInsertId();
        $sql = "INSERT INTO order_book (Order_id, book_id, `count`) VALUES (?, ?, ?)";
        try {
            $stmt = $pdo->prepare($sql);
            foreach ($items as $item) {
                $stmt ->execute([
                    $orderId,
                    $item['idBook'],
                    $item['count']
                ]);
            }
        } catch (PDOException $e) {
            var_dump($e['message']);
            die();
        }
    }

    return $orderId;
}

/**
 * @return float
 */
function getOrderTotal() : float
{
    static $total;
    if ($total === null) {
        $total = 0.0;
        $items = getCartItms();
        foreach ($items as $item) {
            $total += $item['count'] * $item['coastBook'];
        }
    }
    return $total;
}

/**
 * calc data for pay widget
 *
 * @return string
 */
function getData( )
{
    $data = sprintf('{
    "public_key":"%s",
    "version":"3",
    "action":"pay",
    "amount":"%.2f",
    "currency":"UAH",
    "description":"Book_store",
    "order_id":"%s",
    "result_url":"http://localhost:8080/callback.php",
    }',
    PUBLIC_KEY,
        getOrderTotal(),
        createOrder()
    ) ;

    return base64_encode( $data );
}

/**
 * @return string
 */
function getSignature ()
{
    return base64_encode( sha1( PRIVATE_KEY . getData() .  PRIVATE_KEY , true) );
}

/**
 * @param  string  $data
 */
function updateOrder (string $data)
{
    $paymentData = json_decode(base64_decode($data), true);
//    var_dump($_SESSION);
//    die();
    $_SESSION['orderId'] = $paymentData['order_id'];
    $_SESSION['amount']= $paymentData['amount'];
    $_SESSION['status'] = $paymentData['status'] == 'failure' ? 'failed' : $paymentData['status'];
    $sql = 'UPDATE `order` SET `status` = :status, amount = :amount WHERE order_id = :order_id';
    $pdo = getPDO();
    try {
        $stmt = $pdo->prepare($sql);
        $stmt ->execute([
            'status' => $_SESSION['status'],
            'amount' => $_SESSION['amount'],
            'order_id' => $_SESSION['orderId']
        ]);
    } catch (PDOException $e) { }

    if ($_SESSION['status'] == 'success' ){
        setcookie('cart', '', time() -100, '/');
    }

//    header("Location: ../index.php" );
}

function getPaymentStationMessage ()
{
    if (!empty($_SESSION['orderId'])) {
        $sql = 'SELECT *FROM `order` WHERE order_id = ?';
        $pdo = getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt -> execute ([$_SESSION['orderId']]);
        $order = $stmt -> fetch( PDO::FETCH_ASSOC);
        if ($_SESSION['status'] === 'success') {
            $message = sprintf("Заказ на сумму %s оплачен", $order['amount']);
        }
        else {
            $message = sprintf("При заказе произошла ошибка, заказ на сумму %s  не оплачен", $order['amount']);
        }
        $message .= "
        <script>
        $('#exampleModalCenter').modal('show')
        </script>
        ";
        return $message;
    }
}