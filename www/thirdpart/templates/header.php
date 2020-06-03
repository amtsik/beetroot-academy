<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <?php if ($_SERVER['REQUEST_URI'] === '/cart.php') :?>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/shop-item.css" rel="stylesheet">
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>


<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">-->
<!--    Launch demo modal-->
<!--</button>-->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= isset($_SESSION['status']) ? getPaymentStationMessage() : ''?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item "></li>
                <li class="nav-item ">
                    <a class="nav-link"
                       href="../admin/index.php">Admin
                    </a>
                </li>
                <li class="nav-item <?= $_SERVER['REQUEST_URI'] === '/index.php' ? 'active' : '' ?>">
                    <a class="nav-link"
                       href="../index.php">Home
                    </a>
                </li>
                <li class="nav-item <?= $_SERVER['REQUEST_URI'] === '/page.php' ? 'active' : '' ?>">
                    <a class="nav-link"
                        href="../page.php?book_id=2">
                        Pagephp
                    </a>
                </li>

                <li class="nav-item <?= $_SERVER['REQUEST_URI'] === '/page.php' ? 'active' : '' ?>">
                    <a type="button" class="btn btn-success" href="../cart.php">
                        Корзина <span class="badge badge-light"><?= getItemsCount() ?></span>
                        <span class="sr-only">unread messages</span>
                    </a>
                </li>




<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#">Services</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="#">Contact</a>-->
<!--                </li>-->
            </ul>
        </div>
    </div>
</nav>