<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-item.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?= $_SERVER['DOCUMENT_URI'] === '/thirdpart/index.php' ? 'active' : '' ?>">
                    <a class="nav-link"
                       href="index.php">Home
                    </a>
                </li>
                <li class="nav-item <?= $_SERVER['DOCUMENT_URI'] === '/thirdpart/page.php' ? 'active' : '2' ?>">
                    <a class="nav-link"
                        href="page.php">
                        pagephp
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