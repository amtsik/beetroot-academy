<?php
require '../functions/mysql.php';
define(
    'MONTH_LIST_ARRAY',
    array(
        "",
        "январь",
        "февраль",
        "март",
        "апрель",
        "май",
        "июнь",
        "июль",
        "август",
        "сентябрь",
        "октябрь",
        "ноябрь",
        "декабрь",
    )
);

function getEarningsAnnual (){
    $sql = 'SELECT month(added_at) nmth, sum(amount) from `order` group by nmth
        order by nmth desc limit 1;';
    $pdo = getPDO();
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getTotalEarnings (){
    $sql = "SELECT COUNT(1) FROM `order` where status = 'success';";
    $pdo = getPDO();
    $stmt = $pdo ->query($sql);
    return $stmt->fetch(PDO::FETCH_COLUMN);
}

function getPendingOrders (){
    $sql = "SELECT COUNT(1) FROM `order` where status = 'pending';";
    $pdo = getPDO();
    $stmt = $pdo ->query($sql);
    return $stmt->fetch(PDO::FETCH_COLUMN);
}

function getLastMonthEarnings (){
    $sql = 'SELECT month(added_at) nmth, sum(amount) from `order` group by nmth
        order by nmth desc limit 1;';
    $pdo = getPDO();
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getBestMonthEarnings (){
    $sql = 'SELECT month(added_at) nmth, sum(amount) from `order` group by nmth
        order by sum(amount) desc limit 1;';
    $pdo = getPDO();
    $stmt = $pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

