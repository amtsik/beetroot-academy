<?php
declare(strict_types=1);

/**
 * Class addTestOrders
 */
class addTestOrders
{
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var
     */
    private $sql;
    /**
     * @var
     */
    private $date;
    /**
     * @var
     */
    private $amount;
    /**
     * @var
     */
    private $status;

    /**
     * addTestOrders constructor.
     */
    public function __construct()
    {
        $this->pdo = getPDO();
    }

    /**
     *
     */
    public function addOrders()
    {
        for ($i = 1; $i <= 50; $i++) {
            $this->getDate();
            $this->getAmount();
            $this->getStatus();
            $this->addLineInOrderTable();
            $this->addLineInOrderBookTable();
        }

        die("finished addOrders");
    }

    /**
     *
     */
    private function getDate()
    {
        $this->date = date('Y-m-d H-i-s', rand(mktime(0, 0, 0, 1, 1, 2020), mktime($is_dst = 0)));
    }

    /**
     *
     */
    private function getAmount()
    {
        $this->amount = rand(0, 100000) / 100;
    }

    /**
     *
     */
    private function getStatus()
    {
        $status = 'pending';
        if ($this->amount > 500) {
            $status = 'success';
        }
        if ($this->amount < 50) {
            $status = 'failed';
        }
        $this->status = $status;
    }

    /**
     *
     */
    private function addLineInOrderTable()
    {
        $date = $this->date;
        $amount = $this->amount;
        $status = $this->status;
        $this->sql = sprintf("
            INSERT INTO `order` (`added_at`, `status`, `amount`) 
            VALUES ('%s', '%s', '%s');
        ",
            $date,
            $status,
            $amount
        );

        $this->querySql();
    }

    /**
     *
     */
    private function addLineInOrderBookTable()
    {
        $orderId = $this->pdo->lastInsertId();
        $iRandom = rand(2, 5);
        for ($i = 1; $i < $iRandom; $i++) {
            $this->sql = sprintf("
                INSERT INTO order_book (Order_id, book_id, `count`) 
                VALUES ('%s', '%s', '%s');
            ",
                $orderId,
                rand(1, 99),
                rand(1, 5)
            );
            $this->querySql();
        }
    }

    /**
     *
     */
    private function querySql()
    {
        $this->pdo->query($this->sql);
    }
}