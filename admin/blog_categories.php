<?php
include "header.php";
include "includes/categories.php";

$category = new category($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $category->v_category_title = $_POST['category_title'];
        $category->v_category_meta_title = $_POST['category_meta_title'];
        $category->v_category_path = $_POST['category_path'];
        $category->d_date_created = date("Y-m-d", time());
        $category->d_time_created = date("h:i:s", time());
        if ($category->create()) {
            $flag = "Add category complete !";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $category->v_category_title = $_POST['category_title'];
        $category->v_category_meta_title = $_POST['category_meta_title'];
        $category->v_category_path = $_POST['category_path'];
        $category->d_date_created = date("Y-m-d", time());
        $category->d_time_created = date("h:i:s", time());
        $category->n_category_id = $_POST['category_id'];
        if ($category->update()) {
            $flag = "Edit complete !";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $category->n_category_id = $_POST['category_id'];
        if ($category->delete()) {
            $flag = "Delete complete !";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Admin</title>
    <link rel="icon" href="../images/logo.png" type="image/png">

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <?php include "headermobile.php"; ?>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->

        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <?php include "navbar.php"; ?>
            <!-- HEADER DESKTOP-->
            <?php include "sidebar.php"; ?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">overview</h2>
                                    <?php
                                    if (isset($flag)) {

                                    ?>
                                        <div class="alert alert-success">
                                            <strong><?php echo $flag ?></strong>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Category</strong>
                                    </div>
                                    <form role="form" method="POST" action="">
                                        <div class="card-body card-block">
                                            <div class="form-group">
                                                <label for="company" class=" form-control-label">Category Title</label>
                                                <input type="text" id="company" name="category_title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="vat" class=" form-control-label">Category Meta Title</label>
                                                <input type="text" id="vat" name="category_meta_title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="street" class=" form-control-label">Category Path</label>
                                                <input type="text" name="category_path" id="street" class="form-control">
                                            </div>
                                            <button type="submit" name="add" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Meta Title</th>
                                                <th>Path</th>
                                                <th>Function</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $category->read();
                                            $num = $result->rowCount();
                                            if ($num > 0) {
                                                while ($rows = $result->fetch()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $rows['n_category_id'] ?></td>
                                                        <td><?php echo $rows['v_category_title'] ?></td>
                                                        <td><?php echo $rows['v_category_meta_title'] ?></td>
                                                        <td><?php echo $rows['v_category_path'] ?></td>
                                                        <td>
                                                            <a href="..\blog_categories.php?id=<?php echo $rows['n_category_id'] ?>" class="btn btn-warning btn-sm">View</a>
                                                            <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#edit_category<?php echo $rows['n_category_id'] ?>">
                                                                Edit
                                                            </button>
                                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-toggle="modal" data-target="#delete_category<?php echo $rows['n_category_id'] ?>">Delete</button>


                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <?php
            $result = $category->read();
            $num = $result->rowCount();
            if ($num > 0) {
                while ($rows = $result->fetch()) {
            ?>
                    <div class="modal fade" id="edit_category<?php echo $rows['n_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form role="form" method="POST" action="">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mediumModalLabel">Medium Modal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="company" class=" form-control-label">Category Title</label>
                                            <input type="text" id="company" name="category_title" class="form-control" value="<?php echo $rows['v_category_title'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label">Category Meta Title</label>
                                            <input type="text" id="vat" name="category_meta_title" class="form-control" value="<?php echo $rows['v_category_meta_title'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="street" class=" form-control-label">Category Path</label>
                                            <input type="text" name="category_path" id="street" class="form-control" value="<?php echo $rows['v_category_path'] ?>">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id'] ?>">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" name="edit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Delete -->
                    <div class="modal fade" id="delete_category<?php echo $rows['n_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form role="form" method="POST" action="">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="mediumModalLabel">Medium Modal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <h3>Bạn có muốn xóa Category này không ?</h3>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id'] ?>">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" name="delete" class="btn btn-primary">Confirm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->