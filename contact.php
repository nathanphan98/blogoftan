<?php
include "admin/includes/categories.php";
include "admin/includes/database.php";
include "admin/includes/contact.php";
$database = new database();
$db = $database->connect();

$new_contact = new contact($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit_contact'])) {
    $new_contact->v_fullname = $_POST['c_name'];
    $new_contact->v_email = $_POST['c_email'];
    $new_contact->v_phone = $_POST['c_phone'];
    $new_contact->v_message = $_POST['c_message'];
    $new_contact->d_date_created = date('y-m-d', time());
    $new_contact->d_time_created = date('h:i:s', time());
    $new_contact->f_contact_status = 1;
    $new_contact->create();
  }
}

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
    <?php
    include "sidebar.php";
    ?>
    <!-- END COLORLIB-ASIDE -->
    <div id="colorlib-main">
      <section class="ftco-section contact-section">
        <div class="container">
          <div class="row d-flex mb-5 contact-info">
            <div class="col-md-12 mb-4">
              <h2 class="h4 font-weight-bold">Contact Information</h2>
            </div>
            <div class="w-100"></div>
            <div class="col-md-4">
              <p><span>Address:</span> Tra Vinh Province, Vietnam</p>
            </div>
            <div class="col-md-4">
              <p><span>Email:</span> <a href="mailto:info@yoursite.com">20662001@kthcm.edu.vn</a></p>
            </div>
            <div class="col-md-4">
              <p><span>Website:</span> <a href="#">blogoftan.herokuapp.com</a></p>
            </div>
          </div>
          <div class="row block-9">
            <div class="col-md-6 order-md-last pr-md-5">
              <form name="c_form" id="cForm" onsubmit="return check_contact()" method="post" action="">
                <div class="form-group">
                  <input type="text" name="c_name" id="cName" class="form-control" placeholder="Your Name">
                </div>
                <div class="form-group">
                  <input type="text" name="c_email" id="cEmail" class="form-control" placeholder="Your Email">
                </div>
                <div class="form-group">
                  <input type="text" name="c_phone" id="cPhone" class="form-control" placeholder="Your Phone Number">
                </div>
                <div class="form-group">
                  <textarea name="c_message" id="cMessage" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                  <input name="submit_contact" type="submit" class="btn btn-primary py-3 px-5">
                </div>
              </form>

            </div>

            <div class="col-md-6">
              <div id="map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125870.84796171467!2d106.43119594999999!3d9.641335499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a02f2f18edba3b%3A0x2a45a632027b64c5!2zRHV5w6puIEjhuqNpLCBUcsOgIFZpbmg!5e0!3m2!1svi!2s!4v1658755438326!5m2!1svi!2s" width="500" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
            </div>
          </div>
        </div>
      </section>

      <?php include "footer.php" ?>
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

  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

  <script type="text/javascript">
    function check_contact() {
      if (document.c_form.c_name.value == "") {
        alert("Author name is not empty!");
        document.c_form.c_name.focus();
        return false;
      }
      if (document.c_form.c_phone.value == "") {
        alert("Author phone is not empty2!");
        document.c_form.c_phone.focus();
        return false;
      }
      if (document.c_form.c_email.value == "") {
        alert("Author email is not empty3!");
        document.c_form.c_email.focus();
        return false;
      }
      if (document.c_form.c_message.value == "") {
        alert("Author message is not empty4!");
        document.c_form.c_message.focus();
        return false;
      }
      return true;

    }
  </script>

</body>

</html>