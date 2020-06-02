<?php


require './function/function.php';
require '../classes/OrderService.php';
require '../classes/pagination.php';

$tables = new orderService();
$filters = new pagination();

?>


<!DOCTYPE html>
<html lang="en">

<?php include_once './templates/header.php' ?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <?php include_once './templates/sidebar.php' ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include_once './templates/topbar.php' ?>
            <!-- End of Topbar -->



            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For
                    more information about DataTables, please visit the <a target="_blank"
                                                                           href="https://datatables.net">official
                        DataTables documentation</a>.</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 row">
                        <h6 class="m-0 font-weight-bold text-primary col">Таблица заказов</h6>
                        <div class="btn-group col-lg-2">

                            <?= $filters->getSizeFilter() ?>

                        </div>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Название книги</th>
                                    <th>Статус заказа</th>
                                    <th>Дата заказа</th>
                                    <th>Стоимость заказа</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Название книги</th>
                                    <th>Статус заказа</th>
                                    <th>Дата заказа</th>
                                    <th>Стоимость заказа</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($tables->result as $row) : ?>
                                    <tr>
                                        <td><?= $row['order_id'] ?></td>
                                        <td>
                                            <li><?= $row['title'] ?></li>
                                        </td>
                                        <td><?= $row['status'] ?></td>
                                        <td><?= $row['added_at'] ?></td>
                                        <td><?= $row['amount'] ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                        <?= $filters -> paginate() ?>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php include_once './templates/footer.php' ?>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<?php include_once './templates/logoutModal.php' ?>

<!-- Script JS -->
<?php include_once './templates/script_js.php' ?>

</body>

</html>
