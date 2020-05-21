<?php

require './functions/mysql.php';

$books = getBooks();



?>
<!-- Navigation -->
<?php include_once 'header.php'?>
<!-- Page Content -->


<div class="container">
    <div class="bd-example">
        <div class="container">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Жанр</th>
                    <th scope="col">Рейтинг</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books as $key => $book ): ?>
                    <tr id="<?=$book['idBook'] ?>">
                    <th scope="row"><?=$key + 1 ?></th>
                    <td><a href="./page.php?book_id=<?=$book['idBook'] ?> "><?= $book['titleBook'] ?></a></td>
                    <td><?= $book['authorBook'] ?></td>
                    <td><?= $book['genreBook'] ?></td>
                    <td><span href="<?="?idBook=" .$book['idBook']?>" <?= !$book['commetRating'] ? "hidden" : "" ?> ><?= !$book['commetRating'] ? "рейтинг отсутсвует" : $book['commetRating']?></span></td>
                    </tr>
                <?= !empty($comments) ?>

                <?php if (!empty($comments) && $_GET['idBook'] == $book['idBook'] ) :?>
                <tr>
                    <td class=""colspan="5">fff</td>
                </tr>
                <?php endif ; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include_once 'footer.php'; ?>