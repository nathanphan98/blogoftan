<?php
include "admin/includes/database.php";
include "admin/includes/categories.php";
include "admin/includes/blogs.php";
include "admin/includes/users.php";
include "admin/includes/comments.php";
include "admin/includes/tags.php";

$database = new database();
$db = $database->connect();
$cate = new category($db);
$user = new user($db);
$new_comment = new comment($db);
$new_tag = new tag($db);
$new_blog = new blog($db);

$rs_blog = $new_blog->read_search_bar($_GET['key']);
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

<body onload=pagecolor(); >

	<div id="colorlib-page">
		<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
		<?php include "sidebar.php" ?>
		<!-- END COLORLIB-ASIDE -->
		<div id="colorlib-main">
			<section class="home-slider js-fullheight owl-carousel">
				<div class="slider-item js-fullheight" style="background-image:url(images/bg_2.jpg);">
					<div class="overlay"></div>
					<div class="container-fluid">
						<div class="row no-gutters slider-text slider-text-2 js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
							<div class="col-md-10 text-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
								<h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Discover the Place</h1>
								<p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Find great places to stay, eat, shop, or visit from local experts</p>
							</div>
						</div>
					</div>
				</div>

				<div class="slider-item js-fullheight" style="background-image:url(images/bg_3.jpg);">
					<div class="overlay"></div>
					<div class="container-fluid">
						<div class="row no-gutters slider-text slider-text-2 js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
							<div class="col-md-10 text-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
								<h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Explore and travel</h1>
								<p data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Find great places to stay, eat, shop, or visit from local experts</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="ftco-section">
				<div class="container">
					<div class="row">
						<div class="col-lg-8">
							<div class="row">

								<!-- bai viet -->

								<?php
								$offset = 2;
								$total_page = ceil($new_blog->read_search_bar($_GET['key'])->rowCount() / $offset);
								$get_page = isset($_GET['page']) ? ($_GET['page']) - 1 : 0;
								$blog_from = $get_page * $offset;
								$result = $new_blog->read_blog_by_page($blog_from, $offset, $_GET['key']);
								while ($rows = $result->fetch()) {
								?>
									<div class="col-md-12">
										<div class="blog-entry ftco-animate">
											<a href="#" class="img" style="background-image: url(images/upload/<?php echo $rows['v_main_image_url'] ?>);"></a>
											<div class="text pt-2 mt-3">
												<?php
												$cate->n_category_id = $rows['n_category_id'];
												$cate->read_single();
												?>
												<span class="category mb-1 d-block"><a href="blog_categories.php?id=<?php echo $rows['n_category_id'] ?>"><?php echo $cate->v_category_title; ?></a></span>
												<h3 class="mb-4"><a href="blogs.php?id=<?php echo $rows['n_blog_post_id'] ?>"><?php echo $rows['v_post_title']; ?></a></h3>
												<p class="mb-4"><?php echo $rows['v_post_meta_title']; ?></p>
												<div class="author mb-4 d-flex align-items-center">
													<?php
													$user->n_user_id = $rows['n_user_id'];
													$user->read_single();
													?>
													<a href="#" class="img" style="background-image: url(images/avatars/<?php echo $user->v_image ?>);"></a>
													<div class="ml-3 info">
														<span>Written by</span>
														<h3><a href="#"><?php echo $user->v_fullname ?></a>, <span><?php echo $rows['d_date_created'] ?></span></h3>
													</div>
												</div>
												<div class="meta-wrap d-md-flex align-items-center">
													<?php
													$new_comment->n_blog_post_id = $rows['n_blog_post_id'];
													$rs_comment = $new_comment->read_single_blog_post();
													$num_comment = $rs_comment->rowCount();
													?>
													<div class="half order-md-last text-md-right">
														<p class="meta">
															<span><i class="icon-eye"></i><?php echo $rows['n_blog_post_views'] ?></span>
															<span><i class="icon-comment"></i><?php echo empty($num_comment) ? "0" : "$num_comment" ?></span>
														</p>
													</div>
													<div class="half">
														<p><a href="blogs.php?id=<?php echo $rows['n_blog_post_id'] ?>" class="btn btn-primary p-3 px-xl-4 py-xl-3">Continue Reading</a></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
								}
								?>
								<!-- /bai viet -->
								<div class="row mt-5">
									<div class="col">
										<div class="block-27">
											<ul>
												<li>
													<?php
													$getpage = isset($_GET['page']) ? $_GET['page']:1;
													$k = $_GET['key'];
													for ($i = 1; $i <= $total_page; $i++) {
													?>
														<li ><a id="<?php echo $i ?>" href="discover.php?page=<?php echo $i ?>&key=<?php echo $k ?>"><?php echo $i ?></a></li>
													<?php 
													} 
													?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div><!-- END-->
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
	<script>
		function pagecolor(){
			var color = document.getElementById('<?php echo $getpage; ?>');
			color.style.backgroundColor = "#fd7e14";
			color.style.color = "#fff";
		}
	</script>

</body>

</html>