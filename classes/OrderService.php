<?php
declare(strict_types=1);

class orderService
{
    public $sortBy;
    public $result;
    private $startPage;
    private $limit;
    private $href;

    public function __construct()
    {
        $pdo = getPDO();

        $start = $_GET['page'] ?? 1;
        $limit = $_GET['size'] ?? 8;

        $this->sortBy = $_GET['sort_by'] ?? 'order_id';

        switch ( $this->sortBy ) {
            case 'order_status' :
                $this->sortBy = 'o.status';
                break;
            case 'order_data' :
                $this->sortBy = 'o.added_at';
                break;
            case 'order_amount' :
                $this->sortBy = 'o.amount';
                break;
            default:
                $this->sortBy = 'o.order_id';
        }

        $this->startPage = $start * $limit - $limit;
        $this->limit = $limit;
        $this->href = "?page=$start&size=$limit&sort_by=";
        $query = $this -> createQuery();
        $this->result = $pdo -> query($query) -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTableHead ()
    {
        return "
        <th><a class=\"\" href=\"$this->href" . "order_id\">№ заказа</a></th>
        <th>Название книги</th>
        <th><a class=\"\" href=\"$this->href" . "order_status\">Статус заказа</a></th>
        <th><a class=\"\" href=\"$this->href" . "order_data\">Дата заказа</a></th>
        <th><a class=\"\" href=\"$this->href" . "order_amount\">Стоимость заказа</a></th>
        ";
    }

    private function createQuery ( ) : string
    {
        return sprintf( "
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
            ORDER BY %s 
            LIMIT %d, %d
            ;
        ",
            $this -> sortBy,
            $this -> startPage,
            $this -> limit
        );
    }

}