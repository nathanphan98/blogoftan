<?php
include "header.php";
include "includes/blogs.php";
include "includes/tags.php";

$new_blog = new blog($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['write_blog'])) {
        $target_file = "../images/upload/";
        if (!empty($_FILES['main_image']['name'])) {
            $main_image = $_FILES['main_image']['name'];
            move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file . $main_image);
        } else {
            $main_image = "";
        }

        if (!empty($_FILES['second_image']['name'])) {
            $second_image = $_FILES['second_image']['name'];
            move_uploaded_file($_FILES['second_image']['tmp_name'], $target_file . $second_image);
        } else {
            $second_image = $_POST['old_second_image'];
        }

        if (!empty($_FILES['alt_image']['name'])) {
            $alt_image = $_FILES['alt_image']['name'];
            move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file . $alt_image);
        } else {
            $alt_image = "";
        }
        $new_blog->v_post_title = $_POST['title'];
        $new_blog->v_post_meta_title = $_POST['meta_title'];
        $new_blog->n_category_id = $_POST['select_category'];
        $new_blog->v_main_image_url = $main_image;
        $new_blog->v_second_image_url = $second_image;
        $new_blog->v_alt_image_url = $alt_image;
        $new_blog->v_post_summary = $_POST['blog_summary'];
        $new_blog->v_post_content = $_POST['blog_content'];
        $new_blog->v_post_path = $_POST['blog_path'];
        $new_blog->n_blog_post_views = 0;
        $new_blog->f_post_status = $_POST['status'];
        $new_blog->d_date_created = date("Y-m-d", time());
        $new_blog->d_time_created = date("h:i:s", time());
        $new_blog->n_user_id = $_SESSION['user_id'];
        if ($new_blog->create()) {
            $flag = "Write complete !";
            header("location:blogs.php");
        }
        $new_tag = new tag($db);
        $new_tag->n_blog_post_id = $new_blog->last_id();
        $new_tag->v_tag = $_POST['blog_tags'];
        $new_tag->create();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $target_file = "../images/upload/";
        if (!empty($_FILES['main_image']['name'])) {
            $main_image = $_FILES['main_image']['name'];
            move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file . $main_image);
        } else {
            $main_image = $_POST['old_main_image'];
        }

        if (!empty($_FILES['second_image']['name'])) {
            $second_image = $_FILES['second_image']['name'];
            move_uploaded_file($_FILES['second_image']['tmp_name'], $target_file . $second_image);
        } else {
            $second_image = $_POST['old_second_image'];
        }

        if (!empty($_FILES['alt_image']['name'])) {
            $alt_image = $_FILES['alt_image']['name'];
            move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file . $alt_image);
        } else {
            $alt_image = $_POST['old_alt_image'];
        }

        $new_blog->n_blog_post_id = $_POST['blog_id'];
        $new_blog->n_category_id = $_POST['select_category'];
        $new_blog->v_post_title = $_POST['title'];
        $new_blog->v_post_meta_title = $_POST['meta_title'];
        $new_blog->v_post_path = $_POST['blog_path'];
        $new_blog->v_post_summary = $_POST['blog_summary'];
        $new_blog->v_post_content = $_POST['blog_content'];
        $new_blog->v_main_image_url = $main_image;
        $new_blog->v_second_image_url = $second_image;
        $new_blog->v_alt_image_url = $alt_image;
        $new_blog->n_blog_post_views = $_POST['post_view'];
        $new_blog->f_post_status = $_POST['status'];
        $new_blog->d_date_created = $_POST['date_created'];
        $new_blog->d_time_created = $_POST['time_created'];
        $new_blog->d_date_updated = date("Y-m-d", time());
        $new_blog->d_time_updated = date("h:i:s", time());

        if ($new_blog->update()) {
            $flag = "Update successful!";
        }
        $new_tag = new tag($db);
        $new_tag->n_blog_post_id = $new_blog->n_blog_post_id;
        $new_tag->v_tag = $_POST['blog_tags'];
        $new_tag->update();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $new_tag = new tag($db);
        $new_tag->n_blog_post_id = $_POST['blog_id'];
        $new_tag->delete();

        if ($_POST['main_image'] != "") {
            unlink("../images/upload/" . $_POST['main_image']);
        }

        if ($_POST['second_image'] != "") {
            unlink("../images/upload/" . $_POST['second_image']);
        }

        if ($_POST['alt_image'] != "") {
            unlink("../images/upload/" . $_POST['alt_image']);
        }

        $new_blog->n_blog_post_id = $_POST['blog_id'];
        if ($new_blog->delete()) {
            $flag = "Delete successful!";
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
                                        <strong>Blog</strong>
                                    </div>
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
                                                <th>Views</th>
                                                <th>Status</th>
                                                <th>Function</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $new_blog->n_user_id = $_SESSION['user_id'];
                                            $result = $new_blog->read_by_user_id();

                                            $num = $result->rowCount();
                                            if ($num > 0) {
                                                while ($rows = $result->fetch()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $rows['n_blog_post_id'] ?></td>
                                                        <td><?php echo $rows['v_post_title'] ?></td>
                                                        <td><?php echo $rows['n_blog_post_views'] ?></td>
                                                        <td><?php echo $rows['f_post_status'] ?></td>
                                                        <td>
                                                            <a class="btn btn-warning btn-sm" href="..\blogs.php?id=<?php echo $rows['n_blog_post_id'] ?>">View</a>
                                                            <button class="btn btn-warning btn-sm" type="button" onclick="location.href='edit_blogs.php?id=<?php echo $rows['n_blog_post_id'] ?>'">
                                                                Edit
                                                            </button>
                                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-toggle="modal" data-target="#delete_blog<?php echo $rows['n_blog_post_id'] ?>">Delete</button>


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
            $result = $new_blog->read_by_user_id();
            $num = $result->rowCount();
            if ($num > 0) {
                while ($rows = $result->fetch()) {
            ?>
                    <div class="modal fade" id="delete_blog<?php echo $rows['n_blog_post_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
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
                                        <h3>Bạn có muốn xóa Blog này không ?</h3>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="main_image" value="<?php echo $rows['v_main_image_url'] ?>">
                                        <input type="hidden" name="second_image" value="<?php echo $rows['v_second_image_url'] ?>">
                                        <input type="hidden" name="alt_image" value="<?php echo $rows['v_alt_image_url'] ?>">
                                        <input type="hidden" name="blog_id" value="<?php echo $rows['n_blog_post_id']; ?>">
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