<?php

require './functions/mysql.php';

$books = getBooks();


?>
<!-- Navigation -->
<?php include_once 'header.php'?>
<!-- Page Content -->

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron my-4">
            <h1 class="display-3">A Warm Welcome!</h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
            <a href="#" class="btn btn-primary btn-lg">Call to action!</a>
        </header>

        <!-- Page Features -->
        <div class="row text-center">

            <?php foreach ($books as $key => $book ): ?>

                <div class="col-lg-3 col-md-6 mb-4" id="<?=$book['idBook'] ?>">
                    <div class="card h-100">
                        <img class="card-img-top" src="http://placehold.it/500x325" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?= $book['titleBook'] ?></h4>
                            <p class="card-text">
                                Книга в жанре "<?= $book['genreBook'] ?>" <br />
                                Автор "<?= $book['authorBook'] ?>"
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="./page.php?book_id=<?=$book['idBook'] ?> " class="btn btn-primary">Узнать больше!</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

<!--    <div class="container">-->
<!--    <div class="bd-example">-->
<!--        <div class="container">-->
<!--            <table class="table">-->
<!--                <thead class="thead-dark">-->
<!--                <tr>-->
<!--                    <th scope="col">#</th>-->
<!--                    <th scope="col">Название</th>-->
<!--                    <th scope="col">Автор</th>-->
<!--                    <th scope="col">Жанр</th>-->
<!--                    <th scope="col">Рейтинг</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                --><?php //foreach ($books as $key => $book ): ?>
<!--                    <tr id="--><?//=$book['idBook'] ?><!--">-->
<!--                    <th scope="row">--><?//=$key + 1 ?><!--</th>-->
<!--                    <td><a href="./page.php?book_id=--><?//=$book['idBook'] ?><!-- ">--><?//= $book['titleBook'] ?><!--</a></td>-->
<!--                    <td>--><?//= $book['authorBook'] ?><!--</td>-->
<!--                    <td>--><?//= $book['genreBook'] ?><!--</td>-->
<!--                    <td><span href="--><?//="?idBook=" .$book['idBook']?><!--" --><?//= !$book['commentRating'] ? "hidden" : "" ?><!-- >--><?//= !$book['commentRating'] ? "рейтинг отсутсвует" : $book['commentRating']?><!--</span></td>-->
<!--                    </tr>-->
<!--                --><?//= !empty($comments) ?>
<!---->
<!--                --><?php //endforeach; ?>
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->


    <!--Пагинация-->

    <?= paginate() ?>

    <!--Пагинация-->


<?php include_once 'footer.php'; ?>