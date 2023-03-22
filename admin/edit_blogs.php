<?php
include "header.php";
include "includes/categories.php";
include "includes/blogs.php";
include "includes/tags.php";

$new_blog = new blog($db);

if (isset($_GET['id'])) {

    $new_blog->n_blog_post_id = $_GET['id'];
    $new_blog->read_single();
    if ($new_blog->n_user_id != $_SESSION['user_id']) {
        header("location:blogs.php");
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

    <!-- include summernote css/js -->
    <link href="summernote/summernote.min.css" rel="stylesheet">

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
                                        <strong>Edit a blog</strong>
                                    </div>
                                    <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                        <div class="card-body card-block">
                                            <div class="form-group">
                                                <label for="company" class=" form-control-label">Title</label>
                                                <input type="text" id="company" value="<?php echo $new_blog->v_post_title ?>" name="title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="vat" class=" form-control-label">Meta Title</label>
                                                <input type="text" id="vat" value="<?php echo $new_blog->v_post_meta_title ?>" name="meta_title" class="form-control">
                                            </div>
                                            <?php
                                            $cate = new category($db);
                                            $result = $cate->read();
                                            ?>
                                            <div class="form-group">
                                                <label>Blog Categories</label>
                                                <select name="select_category" class="form-control">
                                                    <?php
                                                    while ($rs = $result->fetch()) {
                                                    ?>
                                                        <option value="<?php echo $rs['n_category_id'] ?>" <?php echo $rs['n_category_id'] == $new_blog->n_category_id ? "selected" : "" ?>>
                                                            <?php echo $rs['v_category_title'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <input type="file" name="main_image">
                                                <?php
                                                if ($new_blog->v_main_image_url != "") {
                                                ?>
                                                    <br>
                                                    <img src="../images/upload/<?php echo $new_blog->v_main_image_url ?>" width="400px">
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="old_main_image" value="<?php echo $new_blog->v_main_image_url ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Second Image</label>
                                                <input type="file" name="second_image">
                                                <?php
                                                if ($new_blog->v_second_image_url != "") {
                                                ?>
                                                    <br>
                                                    <img src="../images/upload/<?php echo $new_blog->v_second_image_url ?>" width="400px">
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="old_second_image" value="<?php echo $new_blog->v_second_image_url ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Alt Image</label>
                                                <input type="file" name="alt_image">
                                                <?php
                                                if ($new_blog->v_alt_image_url != "") {
                                                ?>
                                                    <br>
                                                    <img src="../images/upload/<?php echo $new_blog->v_alt_image_url ?>" width="400px">
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="old_alt_image" value="<?php echo $new_blog->v_alt_image_url ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea id="summernote_summary" name="blog_summary" class="form-control" rows="3"><?php echo htmlspecialchars_decode($new_blog->v_post_summary) ?></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Blog Content</label>
                                                <textarea id="summernote_content" name="blog_content" class="form-control" rows="3"><?php echo htmlspecialchars_decode($new_blog->v_post_content) ?></textarea>
                                            </div>

                                            <?php
                                            $tag = new tag($db);
                                            $tag->n_blog_post_id = $new_blog->n_blog_post_id;
                                            $tag->read_single();

                                            ?>
                                            <div class="form-group">
                                                <label>Blog Tags (separated by comma)</label>
                                                <input name="blog_tags" value="<?php echo $tag->v_tag; ?>" class="form-control" placeholder="Enter path category">
                                            </div>

                                            <div class="form-group">
                                                <label for="street" class=" form-control-label">Blog Path</label>
                                                <input type="text" value="<?php echo $new_blog->v_post_path ?>" name="blog_path" id="street" class="form-control">
                                            </div>
                                            
                                            <div class="form-group">
                                            <label>Blog status</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="optionsRadiosInline1" value="1" 
                                                <?php echo $new_blog->f_post_status==1?"checked":"" ?>>Show
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="optionsRadiosInline2" value="0"
                                                <?php echo $new_blog->f_post_status==0?"checked":"" ?>>Hide
                                            </label>
                                            </div>

                                            <input type="hidden" name="blog_id" value="<?php echo $new_blog->n_blog_post_id ?>">
                                            <input type="hidden" name="date_created" value="<?php echo $new_blog->d_date_created ?>">
                                            <input type="hidden" name="time_created" value="<?php echo $new_blog->d_time_created ?>">
                                            <input type="hidden" name="post_view" value="<?php echo $new_blog->n_blog_post_views ?>">
                                            <button name="edit" type="submit" class="btn btn-primary">Update Blog</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->

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

    <script src="summernote/summernote.min.js"></script>
    <script>
        $('#summernote_summary').summernote({
            placeholder: 'Blog summary',
            height: 100
        });

        $('#summernote_content').summernote({
            placeholder: 'Blog content',
            height: 200
        });
    </script>

</body>

</html>
<!-- end document-->