<?php
include "admin/includes/database.php";
include "admin/includes/categories.php";
include "admin/includes/blogs.php";

$database = new database();
$db = $database->connect();
$new_category = new category($db);


$new_blog = new blog($db);
$rs_blog = $new_blog->read_client();

$i=1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Nathan</title>
  <link rel="icon" href="images/logo.png" type="image/png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700" rel="stylesheet">

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/ionicons.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div id="colorlib-page">
    <a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
    <?php include "sidebar.php"; ?>
    <!-- END COLORLIB-ASIDE -->
    <div id="colorlib-main">
      <section class="ftco-section-2">
        <div class="photograhy">
          <div class="row no-gutters">
            <?php
            while ($rows = $rs_blog->fetch()) {
            ?>
              <div class="col-md-3">
                <a href="blogs.php?id=<?php echo $rows['n_blog_post_id'] ?>" class="photography-entry img d-flex justify-content-center align-items-center" style="background-image: url(images/upload/<?php echo $rows['v_main_image_url'] ?>);">
                  <div class="overlay"></div>
                  <?php
                  $new_category->n_category_id = $rows['n_category_id'];
                  $new_category->read_single();
                  ?>
                  <div class="text text-center">
                    <h3>Picture <?php echo $i++; ?></h3>
                    <span><?php echo $new_category->v_category_title; ?></span>
                  </div>
                </a>
              </div>
            <?php } ?>

          </div>
        </div>
      </section>
      <?php include "footer.php"; ?>
    </div><!-- END COLORLIB-MAIN -->
  </div><!-- END COLORLIB-PAGE -->

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

</body>

</html>