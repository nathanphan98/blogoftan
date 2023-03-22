<?php
include "admin/includes/database.php";
include "admin/includes/blogs.php";
include "admin/includes/tags.php";
include "admin/includes/comments.php";
include "admin/includes/categories.php";
include "admin/includes/users.php";

$database = new database();
$db = $database->connect();


$user = new user($db);
$new_comment = new comment($db);
$new_tag = new tag($db);

$new_blog = new blog($db);

$new_blog->n_blog_post_id = $_GET['id'];
$new_blog->read_single_client();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['submit_comment'])) {
		$new_comment->n_blog_comment_parent_id = 0;
		$new_comment->n_blog_post_id = $_GET['id'];
		$new_comment->v_comment_author = $_POST['c_name'];
		$new_comment->v_comment_author_email = $_POST['c_email'];
		$new_comment->v_comment = $_POST['c_message'];
		$new_comment->d_date_created = date('y-m-d', time());
		$new_comment->d_time_created = date('h:i:s', time());
		$new_comment->create();
		header("location:blogs.php?id=$new_comment->n_blog_post_id");
	}

	if (isset($_POST['submit_comment_reply'])) {
		$new_comment->n_blog_comment_parent_id = $_POST['blog_comment_id'];
		$new_comment->n_blog_post_id = $_GET['id'];
		$new_comment->v_comment_author = $_POST['c_name_reply'];
		$new_comment->v_comment_author_email = $_POST['c_email_reply'];
		$new_comment->v_comment = $_POST['c_message_reply'];
		$new_comment->d_date_created = date('y-m-d', time());
		$new_comment->d_time_created = date('h:i:s', time());
		$new_comment->create();
		header("location:blogs.php?id=$new_comment->n_blog_post_id");
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

<body id="top" onload="hide_form_reply()">

	<div id="colorlib-page">
		<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
		<?php include "sidebar.php" ?>
		<!-- END COLORLIB-ASIDE -->
		<div id="colorlib-main">
			<div class="hero-wrap js-fullheight" style="background-image: url(images/bg_1.jpg);" data-stellar-background-ratio="0.5">
				<div class="overlay"></div>
				<div class="js-fullheight d-flex justify-content-center align-items-center">
					<div class="col-md-8 text text-center">
						<div class="desc">
							<h1 class="mb-4">Blog Details</h1>
							<p><a href="index" class="btn-custom mr-2">Home <span class="ion-ios-arrow-forward"></span></a> <a href="index" class="btn-custom mr-2">Blog <span class="ion-ios-arrow-forward"></span></a> <a href="index" class="btn-custom">Single <span class="ion-ios-arrow-forward"></span></a></p>
						</div>
					</div>
				</div>
			</div>
			<section class="ftco-section">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 ftco-animate">
							<h2 class="mb-3 font-weight-bold"><?php echo $new_blog->v_post_title ?></h2>
							<p><?php echo $new_blog->v_post_meta_title ?></p>
							<p>
								<img src="images/upload/<?php echo $new_blog->v_main_image_url ?>" alt="" class="img-fluid">
							</p>
							<p>
								<?php echo htmlspecialchars_decode($new_blog->v_post_summary) ?>
							</p>
							<p>
								<!-- rãnh thì thêm thêm 1 hình nữa -->
								<img src="images/upload/<?php echo $new_blog->v_second_image_url ?>" alt="" class="img-fluid">
							</p>
							<p><?php echo htmlspecialchars_decode($new_blog->v_post_content) ?> </p>
							<!-- phần tag -->
							<?php
							$new_tag->n_blog_post_id = $_GET['id'];
							$new_tag->read_single();
							$new_tag_arr = explode(',', $new_tag->v_tag);
							?>
							<div class="tag-widget post-tag-container mb-5 mt-5">
								<div class="tagcloud">
									<?php foreach ($new_tag_arr as $new_tag_item) { ?>
										<a href="discover.php?key=<?php echo $new_tag_item ?>" class="tag-cloud-link"><?php echo $new_tag_item ?></a>
									<?php } ?>
								</div>
							</div>

							<?php
							$user->n_user_id = $new_blog->n_user_id;
							$user->read_single();
							?>


							<div class="about-author d-flex p-4 bg-light">
								<div class="bio mr-5">
									<img style="width:170px ;" src="images/avatars/<?php echo $user->v_image ?>" alt="Image placeholder" class="img-fluid mb-4">
								</div>
								<div class="desc">
									<h3><?php echo $user->v_fullname ?></h3>
									<p><?php echo $user->v_message ?></p>
								</div>
							</div>
							<?php
							$new_blog->n_blog_post_id = $_GET['id'];
							$rs_next = $new_blog->read_next();
							$rs_previous = $new_blog->read_previous();
							?>
							<div class="row">
								<div class="col-md-6">
									<h3 class="sidebar-heading">Previous Article</h3>
									<?php
									if ($previous = $rs_previous->fetch()) {
									?>
										<div class="block-21 mb-4 d-flex">
											<a class="blog-img mr-4" href="blogs.php?id=<?php echo $previous['n_blog_post_id'] ?>" style="background-image: url(images/upload/<?php echo $previous['v_main_image_url'] ?>);"></a>
											<div class="text">
												<h3 class="heading"><a href="blogs.php?id=<?php echo $previous['n_blog_post_id'] ?>"><?php echo $previous['v_post_title']; ?></a></h3>
												<div class="meta">
													<div><a href="blogs.php?id=<?php echo $previous['n_blog_post_id'] ?>"><span class="icon-calendar"></span> <?php echo $previous['d_date_created'] ?></a></div>
													<span><i class="icon-eye"></i><?php echo $previous['n_blog_post_views'] ?></span>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="col-md-6">
									<?php
									if ($next = $rs_next->fetch()) {
									?>
										<h3 class="sidebar-heading">Next Article</h3>
										<div class="block-21 mb-4 d-flex">
											<a class="blog-img mr-4" href="blogs.php?id=<?php echo $next['n_blog_post_id'] ?>" style="background-image: url(images/upload/<?php echo $next['v_main_image_url'] ?>);"></a>
											<div class="text">
												<h3 class="heading"><a href="blogs.php?id=<?php echo $next['n_blog_post_id'] ?>"><?php echo $next['v_post_title']; ?></a></h3>
												<div class="meta">
													<div><a href="blogs.php?id=<?php echo $next['n_blog_post_id'] ?>"><span class="icon-calendar"></span> <?php echo $next['d_date_created'] ?></a></div>
													<span><i class="icon-eye"></i><?php echo $next['n_blog_post_views'] ?></span>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<!-- comments  
	            ================================================== -->
							<?php
							$new_comment->n_blog_post_id = $_GET['id'];
							$rs_comment = $new_comment->read_single_blog_post();
							$num_comment = $rs_comment->rowCount();
							?>
							<div class="pt-5 mt-5">
								<h3 class="mb-5 font-weight-bold"><?php echo empty($num_comment) ? "Comments" : "$num_comment Comments" ?></h3>
								<ul class="comment-list">
									<?php
									while ($rows = $rs_comment->fetch()) {
										if ($rows['n_blog_comment_parent_id'] == 0) {
									?>
											<li class="comment">
												<div class="vcard bio">
													<img src="images/person_1.jpg" alt="Image placeholder">
												</div>
												<div class="comment-body">
													<h3><?php echo $rows['v_comment_author'] ?></h3>
													<div class="meta"><?php echo $rows['d_date_created'] ?></div>
													<p><?php echo $rows['v_comment'] ?></p>
													<p><a href="#reply" class="reply" onclick="reply_comment(<?php echo $rows['n_blog_comment_id'] ?>)">Reply</a></p>
												</div>
												<?php
												$new_comment->n_blog_comment_id = $rows['n_blog_comment_id'];
												$rs_sub_comment = $new_comment->read_single_blog_post_reply();
												while ($rows_sub = $rs_sub_comment->fetch()) {
												?>
													<ul class="children">
														<li class="comment">
															<div class="vcard bio">
																<img src="images/person_1.jpg" alt="Image placeholder">
															</div>
															<div class="comment-body">
																<h3><?php echo $rows_sub['v_comment_author'] ?></h3>
																<div class="meta"><?php echo $rows_sub['d_date_created'] ?></div>
																<p><?php echo $rows_sub['v_comment'] ?></p>

															</div>
														</li>
													</ul>
												<?php } ?>
											</li>
									<?php }
									} ?>
									<!-- END comment-list -->
									<!-- comment-form -->
									<!-- Respond -->
									<div id="respond" class="comment-form-wrap pt-5">
										<h3 class="mb-5">Leave a comment</h3>
										<form name="cmt_form" onsubmit="return check_respond()" id="contactForm" method="post" action="" class="p-3 p-md-5 bg-light">
											<div class="form-group">
												<label for="name">Name *</label>
												<input name="c_name" id="cName" type="text" class="form-control" id="name">
											</div>
											<div class="form-group">
												<label for="email">Email *</label>
												<input name="c_email" id="cEmail" type="email" class="form-control" id="email">
											</div>

											<div class="form-group">
												<label for="message">Message</label>
												<textarea name="c_message" id="cMessage" cols="30" rows="10" class="form-control"></textarea>
											</div>
											<div class="form-group">
												<input type="submit" name="submit_comment" id="submit" value="Post Comment" class="btn py-3 px-4 btn-primary">
											</div>
										</form>
									</div>

									<!-- Reply -->
									<div id="reply" class="comment-form-wrap pt-5">
										<h3 class="mb-5">Reply comment</h3>
										<form name="cmt_form_reply" onsubmit="return check_reply()" id="contactForm" method="post" action="" class="p-3 p-md-5 bg-light">
											<div class="form-group">
												<label for="name">Name *</label>
												<input name="c_name_reply" id="cName" type="text" class="form-control" id="name">
											</div>
											<div class="form-group">
												<label for="email">Email *</label>
												<input name="c_email_reply" id="cEmail" type="email" class="form-control" id="email">
											</div>

											<div class="form-group">
												<label for="message">Message</label>
												<textarea name="c_message_reply" id="cMessage" cols="30" rows="10" class="form-control"></textarea>
											</div>
											<div class="form-group">
												<input type="hidden" name="blog_comment_id">
												<input type="submit" name="submit_comment_reply" id="submit" value="Reply Comment" class="btn py-3 px-4 btn-primary">
											</div>
										</form>
									</div>
									<!--End comment-form -->

							</div>

						</div>
						<!-- .col-md-8 -->
						<?php include "right_sidebar.php"; ?>

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
	<script type="text/javascript">
		var blog_comment_id;

		function reply_comment(comment_id) {
			blog_comment_id = comment_id;
			document.getElementById("respond").style.display = "none";
			document.getElementById("reply").style.display = "block";
		}

		function hide_form_reply() {
			document.getElementById("reply").style.display = "none";
		}

		function check_respond() {
			if (document.cmt_form.c_name.value == "") {
				alert("Author name is not empty!");
				document.cmt_form.c_name.focus();
				return false;
			}
			if (document.cmt_form.c_email.value == "") {
				alert("Author email is not empty!");
				document.cmt_form.c_email.focus();
				return false;
			}
			if (document.cmt_form.c_message.value == "") {
				alert("Author message is not empty!");
				document.cmt_form.c_message.focus();
				return false;
			}
			return true;

		}

		function check_reply() {

			if (document.cmt_form_reply.c_name_reply.value == "") {
				alert("Author name is not empty!");
				document.cmt_form_reply.c_name_reply.focus();
				return false;
			}
			if (document.cmt_form_reply.c_email_reply.value == "") {
				alert("Author email is not empty!");
				document.cmt_form_reply.c_email_reply.focus();
				return false;
			}
			if (document.cmt_form_reply.c_message_reply.value == "") {
				alert("Author message is not empty!");
				document.cmt_form_reply.c_message_reply.focus();
				return false;
			}
			document.cmt_form_reply.blog_comment_id.value = blog_comment_id;
			return true;

		}
	</script>

</body>

</html>