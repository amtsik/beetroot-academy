<?php

require './functions/mysql.php';

if (!empty($_GET['book_id'])) {
    $book = getBooksByID($_GET['book_id']);
    $comments = getBookComment($_GET['book_id']);
//    var_dump($comments);
//    die();
}
else {
    header("Location: /thirdpart/index.php");
}

?>

<?php include_once 'header.php'?>
<!-- Page Content -->

<div class="container">

    <div class="row">

        <div class="col-lg-3">
            <h1 class="my-4">BOOKS SHOP</h1>
            <div class="list-group">
                <?php foreach (getGenres() as $genre) : ?>
                    <a href="#" class="list-group-item <?=$genre['id'] == $book['genreBookId'] ? 'active' : ''?>"><?=$genre['name'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
                <div class="card-body">
                    <h3 class="card-title"><?=$book['titleBook'] ?></h3>
                    <h4>$24.99</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit fugiat hic aliquam itaque facere, soluta. Totam id dolores, sint aperiam sequi pariatur praesentium animi perspiciatis molestias iure, ducimus!</p>

                    <small class="text-muted">Средний рейтин книиги:
                        <?= $book['commetRating'] ?>
                    </small>

                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>
                <div class="card-body">
                    <?php foreach ($comments as $comment) : ?>
                    <p><?= $comment['message'] ?></p>
                    <small class="text-muted">Рейтинг книиги:
                        <span class="text-warning"><?= str_repeat('&#9733;', (int)$comment['rating']) . str_repeat('&#9734;', 5 - (int)$comment['rating'])?></span>
                        <?= $comment['rating'] = (int)$comment['rating']?>
                        <span>звезд<?= $comment['rating'] === 1 ? 'а' : (($comment['rating'] === 2 || $comment['rating'] === 3 || $comment['rating'] === 4) ? 'ы' : '') ?></span>
                    </small>
                    <hr>
                    <?php endforeach; ?>
                    <a href="#" class="btn btn-success">Leave a Review</a>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->
<?php include_once 'footer.php'; ?>
