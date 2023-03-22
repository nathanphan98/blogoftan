<?php
include "admin/includes/subscriber.php";

$new_category = new category($db);
$result = $new_category->read();
$user = new user($db);
$rs_p = $new_blog->read_popular();

$new_tag = new tag($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['email']) != "") {
    $new_subscribe = new subscriber($db);
    $new_subscribe->v_sub_email = $_POST['email'];
    $new_subscribe->d_date_created = date('y-m-d', time());
    $new_subscribe->d_time_created = date('h:i:s', time());
    $new_subscribe->f_sub_status = 1;
    $new_subscribe->create();
  }
}

$all_tags = $new_tag->read_50();


?>

<div class="col-lg-4 sidebar ftco-animate">

  <div class="sidebar-box ftco-animate">
    <h3 class="sidebar-heading">Categories</h3>
    <ul class="categories">
      <?php
      while ($rows = $result->fetch()) {
      ?>
        <li><a href="blog_categories.php?id=<?php echo $rows['n_category_id'] ?>"><?php echo $rows['v_category_title'] ?></a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="sidebar-box ftco-animate">
    <h3 class="sidebar-heading">Popular Articles</h3>
    <?php
    while ($rows = $rs_p->fetch()) {
    ?>
      <div class="block-21 mb-4 d-flex">
        <a class="blog-img mr-4" style="background-image: url(images/upload/<?php echo $rows['v_main_image_url'] ?>);"></a>
        <div class="text">
          <h3 class="heading"><a href="blogs.php?id=<?php echo $rows['n_blog_post_id'] ?>"><?php echo $rows['v_post_title']; ?></a></h3>
          <?php
          $user->n_user_id = $rows['n_user_id'];
          $user->read_single();
          ?>
          <div class="meta">
            <div><a href="#"><span class="icon-calendar"></span> <?php echo $rows['d_date_created'] ?></a></div>
            <div><a href="#"><span class="icon-person"></span> <?php echo $user->v_fullname ?> </a></div>
            <span><i class="icon-eye"></i><?php echo $rows['n_blog_post_views'] ?></span>
          </div>
        </div>
      </div>
    <?php
    }
    ?>
  </div>


  <div class="sidebar-box ftco-animate">
    <h3 class="sidebar-heading">Tag Cloud</h3>
    <ul class="tagcloud">
      <?php
      while ($rows = $all_tags->fetch()) {
        $new_tag_arr = explode(',', $rows['v_tag']);
      ?>
        <?php foreach ($new_tag_arr as $new_tag_item) { ?>
          <a href="discover.php?page=1&key=<?php echo $new_tag_item ?>" class="tag-cloud-link"><?php echo $new_tag_item ?></a>
      <?php }
      } ?>
    </ul>
  </div>
  <div class="sidebar-box subs-wrap img" style="background-image: url(images/bg_1.jpg);">
    <div class="overlay"></div>
    <h3 class="mb-4 sidebar-heading">Newsletter</h3>
    <p class="mb-4">Far far away, behind the word mountains!!</p>
    <form action="" method="POST" class="subscribe-form">
      <div class="form-group">
        <input type="text" name="email" id="email" class="form-control" placeholder="Email Address">
        <input type="submit" name="subscribe" class="mt-2 btn btn-white submit" onclick="checksubscribe()">
      </div>
    </form>
  </div>

  <div class="sidebar-box ftco-animate">
    <h3 class="sidebar-heading">Maxim</h3>
    <p>Be who you are and say what you mean, because those who mind don’t matter and those who matter don’t mind. ― Dr. Seuss.</p>
  </div>

</div><!-- END COL -->
</div>
<script>
  function checksubscribe(){
    if(document.getElementById("email").value==""){
      alert("Please enter your email !");
    }else{
      alert("Thank your your subscribe !");
    }
  }
</script>