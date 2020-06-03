<?php
declare(strict_types = 1);

/**
 * Class GenreService
 */

class GenreService
{
    /**
     * @return mixed
     */
    public function getGenreStates()
    {
        $sql = "
        SELECT g.name, count(b.id) total
        from book b
        join genre g on g.id = b.genre_id
        group by g.name order by total;
        ";
        $pdo = getPDO();
        $stmt = $pdo->query($sql);
        $stats =  $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return $this->showAsPercents( $stats );
    }

    /**
     * @param $stats
     * @return mixed
     */
    private function showAsPercents ( $stats )
    {
        $totalBook = array_sum( array_column($stats, 'total') ) ;
        foreach ($stats as &$stat) {
            $stat['total'] = round( $stat['total'] * 100 / $totalBook, 1) ;
        }
        return $stats;
    }

}