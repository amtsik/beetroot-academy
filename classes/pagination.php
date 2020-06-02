<?php
declare(strict_types=1);

class pagination
{

    public $sizeFilter;
    public $sortBy;
    public $page;
    public $count;

    public function __construct($query = 'SELECT COUNT(1) FROM `bookstore`.`order`;')
    {
        $this->sizeFilter = $_GET['size'] ?? '8';
        $this->sortBy = $_GET['sort_by'] ?? 'order_id';
        $this->page = $_GET['page'] ?? 1;
        $pdo = getPDO();
        $this->count = $pdo->query($query)->fetch(PDO::FETCH_COLUMN);
    }

    public function paginate()
    {
        $endPost = $startPost = $page = $this->getPageNumber();
        $pageCount = ceil($this->count / ITEMS_PER_PAGE);
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
            $href = "?page=$i&size=".$this->sizeFilter;
            $buttons .= "<li class=\"page-item $active\"><a class=\"page-link\" href=\"$href\">$i</a></li>";
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

    public function getSizeFilter()
    {
        $link = '';

        for ($i = 3; $i <= 6; $i++) {
            $href = "?page=$this->page&size=". pow(2, $i) ;
            $link .= "<a class=\"dropdown-item\" href=\"$href\"> " . pow(2, $i) ."</a>";
        }

        $size =  $this -> sizeFilter;

        $link = "
        <button class=\"btn btn-secondary btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        $size
        </button>
        <div class=\"dropdown-menu\" x-placement=\"bottom-start\" style=\"position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;\">
        $link
        </div>
        ";
        return $link;
    }

    private function getPageNumber(): int
    {
        $page = $this->page;
        $total = getTotal();
        if ($page < 1) {
            $page = 1;
        } elseif ($page > $total) {
            $page = $total;
        }

        return (int)$page;
    }

}