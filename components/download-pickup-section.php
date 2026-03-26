<section class="download-pickup">
  <div class="mainContainer">
    <header class="section-titleArea">
      <div class="section-titleArea__en">Download</div>
      <h2 class="section-titleArea__jp">お役立ち資料ダウンロード</h2>
    </header>
    <?php if (have_rows('download_pickup', 'option')): ?>
      <div class="download-pickup__list">
        <?php while (have_rows('download_pickup', 'option')):

          the_row();
          $post_pickup = get_sub_field('download_pickup_item');
          $post_pickupID = $post_pickup->ID;
          ?>
          <?php get_template_part('components/card', 'download', [
            'id' => $post_pickupID,
          ]); ?>
        <?php
        endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
