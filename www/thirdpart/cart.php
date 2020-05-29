<?php
include_once './functions/mysql.php';

$cart = getCartItms();


//var_dump( $cart );
//
//die();

?>

<?php include_once './templates/header.php' ?>

<div class="jumbotron" style="margin: 0">
    <div class="row">
        <div class="col-xs-8" style="margin: 0 auto">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-primary btn-sm btn-block">
                                    <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php if (!empty($cart)) : ?>
                        <?php foreach ($cart as $item) : ?>
                            <form class="row" action="./functions/post.php" method="post">
                                <div class="col-xs-2"><img class="img-responsive" src="http://placehold.it/100x70">
                                </div>
                                <div class="col-xs-4">
                                    <h4 class="product-name"><strong><a
                                                    href="page.php?book_id=<?= $item['idBook'] ?>"><?= $item['titleBook'] ?></a></strong>
                                    </h4>
                                    <h4><small>автор: <?= $item['authorBook'] ?></small></h4>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-6 text-right">
                                        <h6><strong>₴ <?= $item['coastBook'] ?><span
                                                        class="text-muted">x</span></strong></h6>
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text" hidden name="glyphicon" value="<?= $item['idBook'] ?>">
                                        <input type="text" disabled class="form-control input-sm"
                                               value="<?= $item['count'] ?>">
                                    </div>
                                    <div class="col-xs-2">
                                        <button type="submit" class="btn btn-link btn-xs">
                                            <span class="glyphicon glyphicon-trash"> </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="row">
                            <div class="text-center">
                                В корзине нет товаров
                            </div>
                        </div>
                    <?php endif ?>

                    <!--                    <div class="row">-->
                    <!--                        <div class="text-center">-->
                    <!--                            <div class="col-xs-9">-->
                    <!--                                <h6 class="text-right">Added items?</h6>-->
                    <!--                            </div>-->
                    <!--                            <div class="col-xs-3">-->
                    <!--                                <button type="button" class="btn btn-default btn-sm btn-block">-->
                    <!--                                    Update cart-->
                    <!--                                </button>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-xs-9">
                            <h4 class="text-right">Total: <strong></strong></h4>
                        </div>
                        <div class="col-xs-3">
                            <!--                            <form action="./functions/post.php" method="post">-->
                            <!--                                <input type="hidden" name="Checkout" hidden value="Checkout">-->
                            <!--                                <button type="submit" class="btn btn-success btn-block">-->
                            <!--                                    Checkout-->
                            <!--                                </button>-->
                            <!--                            </form>-->
                            <form method="POST" accept-charset="utf-8" action="https://www.liqpay.ua/api/3/checkout">
                                <input type="hidden" name="data" value="<?= getData() ?>"/>
                                <input type="hidden" name="signature" value="<?= getSignature() ?>"/>
                                <button style="border: none !important; display:inline-block !important;text-align: center !important;padding: 7px 20px !important;
		color: #fff !important; font-size:16px !important; font-weight: 600 !important; font-family:OpenSans, sans-serif; cursor: pointer !important; border-radius: 2px !important;
		background: rgb(122,183,43) !important;" onmouseover="this.style.opacity='0.5';"
                                        onmouseout="this.style.opacity='1';">
                                    <img src="" name="btn_text"
                                         style="margin-right: 7px !important; vertical-align: middle !important;"/>
                                    <span style="vertical-align:middle; !important"><?= getOrderTotal() == 0 ? '' : getOrderTotal() ?> UAH</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->
<?php include_once './templates/footer.php'; ?>


