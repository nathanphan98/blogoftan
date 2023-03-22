<?php
$new_category = new category($db);
$result = $new_category->read();
?>
<footer class="ftco-footer ftco-bg-dark ftco-section">
  <div class="container px-md-5">
    <div class="row mb-10">
      <div class="col-md">
        <div class="ftco-footer-widget mb-4 ml-md-4">
          <h2 class="ftco-heading-2">Category</h2>
          <?php
          while ($rows = $result->fetch()) {
          ?>
            <ul class="list-unstyled categories">
              <li><a href="blog_categories.php?id=<?php echo $rows['n_category_id'] ?>"><?php echo $rows['v_category_title'] ?></a></li>
            <?php } ?>
            </ul>
        </div>
      </div>
      <div class="col-md">
        <div class="ftco-footer-widget mb-4">
          <h2 class="ftco-heading-2">Have a Questions?</h2>
          <div class="block-23 mb-3">
            <ul>
              <li><span class="icon icon-map-marker"></span><span class="text">Duyen Hai, Tra Vinh Province, Vietnam</span></li>
              <li><a href="#"><span class="icon icon-envelope"></span><span class="text">20662001@kthcm.edu.vn</span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>