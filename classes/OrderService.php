<?php
declare(strict_types=1);

class orderService
{
    public $result;
    public $count;

    public function __construct()
    {
        $start = $_GET['page'] ?? 1;
        $limit = $_GET['size'] ?? 8;

        $start = $start * $limit - $limit;


        $pdo = getPDO();
        $query = sprintf( "
            SELECT 
                    o.order_id,
                    group_concat( 
                        '<a class=\"\" target=\"_blank\" href=\"../page.php?book_id=',
                        b.id,
                        '\">',
                        b.title
                        SEPARATOR
                        '</a></li><li>') 'title',
                    o.amount,
                    o.added_at,
                    o.status
            from `bookstore`.`order` o
            join order_book ob on ob.order_id = o.order_id
            join book b ON b.id = ob.book_id
            group by o.order_id
            ORDER BY o.order_id 
            LIMIT %d, %d
            ;
        ",
            $start,
            $limit
        );
        $this -> result = $pdo -> query($query) -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderTable ()
    {

    }


}