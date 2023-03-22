<?php
include "header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_user_profile'])) {
        if (empty($_FILES['image_profile']['name'])) {
            $image_name = $_POST['old_image_profile'];
        } else {
            $target_file = "../images/avatars/";
            $image_name = $_FILES['image_profile']['name'];
            move_uploaded_file($_FILES['image_profile']['tmp_name'], $target_file . $image_name);
        }

        if ($_POST['old_password'] == $_POST['password']) {
            $new_user->v_password = $_POST['old_password'];
        } else {
            $new_user->v_password = md5($_POST['password']);
        }
        $new_user->n_user_id = $_POST['user_id'];
        $new_user->v_username = $_POST['username'];
        $new_user->v_fullname = $_POST['name'];
        $new_user->v_phone = $_POST['phone'];
        $new_user->v_email = $_POST['email'];
        $new_user->v_image = $image_name;
        $new_user->v_message = $_POST['about'];
        $new_user->d_date_updated = date("Y-m-d", time());
        $new_user->d_time_updated = date("h:i:s", time());
        if ($new_user->update()) {
            $flag = "Update complete";
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
                            <?php
                            $new_user->n_user_id = $_SESSION['user_id'];
                            $new_user->read_single();
                            ?>
                            <div class="row">
                                <div class="col-xl-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>User Profile</strong>
                                        </div>
                                        <form role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="card-body card-block">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input name="name" value="<?php echo $new_user->v_fullname ?>" class="form-control" placeholder="Enter full name">
                                                </div>

                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input name="email" value="<?php echo $new_user->v_email ?>" class="form-control" placeholder="Enter email">
                                                </div>

                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input name="username" value="<?php echo $new_user->v_username ?>" class="form-control" placeholder="Enter username">
                                                </div>

                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input name="password" type="password" value="<?php echo $new_user->v_password ?>" class="form-control" placeholder="Enter password">
                                                    <input type="hidden" name="old_password" value="<?php echo $new_user->v_password ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input name="phone" value="<?php echo $new_user->v_phone ?>" class="form-control" placeholder="Enter phone number">
                                                </div>

                                                <div class="form-group">
                                                    <label>Image Profile</label>
                                                    <input type="file" name="image_profile">
                                                    <input type="hidden" name="old_image_profile" value="<?php echo $new_user->v_image ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label>About Me</label>
                                                    <textarea id="summernote_profile" name="about" class="form-control" rows="3">
                                            <?php echo $new_user->v_message ?>
                                            </textarea>
                                                </div>
                                                <input type="hidden" name="user_id" value="<?php echo $new_user->n_user_id ?>">
                                                <button name="edit_user_profile" type="submit" class="btn btn-primary">Update Profile</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- avatar -->
                                <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>Image Profile</strong>
                                        </div>
                                        <div class="panel-body" align="center">
                                            <?php if (empty($new_user->v_image)) {
                                            ?>
                                                <img class="img-thumbnail" src="../images/avatars/user-01.jpg" alt="Vinhs" width="180px">
                                            <?php
                                            } else {
                                            ?>
                                                <img class="img-thumbnail" src="<?php echo "../images/avatars/" . $new_user->v_image ?>" alt="Vinhs" width="180px">
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
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
        $('#summernote_profile').summernote({
            placeholder: 'About me',
            height: 100
        });
    </script>
</body>

</html>
<!-- end document-->