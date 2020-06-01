<?php
require '../functions/mysql.php';

function getPendingOrders (){
    $sql = 'SELECT COUNT(1) ';

}
function getLastMonthEarnings (){
    $sql = 'SELECT month(added_at) nmth, sum(amount) from `order` group by nmth
order by nmth desc limit 1;';
    $pdo = getPDO();
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_COLUMN);
}

function getBestMonthEarnings (){
    $sql = 'SELECT month(added_at) nmth, sum(amount) from `order` group by nmth
order by sum(amount) desc limit 1;';
    $pdo = getPDO();
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
