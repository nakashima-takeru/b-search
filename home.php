<?php

$archive_lead = get_field('posts_archive_lead', 'option');

get_header();
?>

<main class="queryy-main queryy-lower-page">
  <div class="stack60 sp-stack50">
    <div class="queryy-breadcrumb">
      <?php include 'partials/breadcrumbs.php'; ?>
    </div>
    <div>
      <div class="stack80">
        <div class="stack50">
          <header class="queryy-page-header">
            <div class="queryy-page-header__inner mainContainer">
              <div class="queryy-page-header__text">
                <p class="queryy-page-title-en">Articles</p>
                <h1 class="queryy-page-title-ja"><em>全て</em>の記事一覧</h1>
                <?php if ($archive_lead): ?>
                  <div>
                    <div class="queryy-page-desc">
                      <?php echo wpautop( esc_html($archive_lead) ); ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </header>
          <div class="mainContainer">
            <div class="border-overflow-area">
              <?php get_template_part('components/list', 'category'); ?>
            </div>
          </div>
        </div>
        <div class="stack100 mainContainer queryy-archive-list">
          <?php
          $paged = get_query_var('paged') ? get_query_var('paged') : 1;
          $args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $paged,
            'posts_per_page' => 18,
          ];

          $the_query = new WP_Query($args);
          ?>

          <ul class="grid-entries">
            <?php if ($the_query->have_posts()):
              while ($the_query->have_posts()):

                $the_query->the_post();
                $categories = get_the_category();
                ?>
              <li>
                <?php get_template_part('components/card', 'entry', [
                  'categories' => $categories,
                ]); ?>
              </li>
            <?php
              endwhile;
              wp_reset_postdata();
            endif; ?>
          </ul>

          <?php if (function_exists('wp_pagenavi')) {
            wp_pagenavi(['query' => $the_query]);
          } ?>
        </div>
      </div>

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
                $post_pickupID = $post_pickup->ID ?? null;
                if ($post_pickupID) {
                  get_template_part('components/card', 'download', [
                    'id' => $post_pickupID,
                  ]);
                }
              endwhile; ?>
              </div>
            <?php endif; ?>
        </div>
      </section>

      <!-- Ranking-->
      <div class="queryy-ranking-basic-wrapper">
        <?php get_template_part('components/section', 'ranking'); ?>
      </div>

      <div class="stack200 sp-stack150">
        <div class="recommend-section-wrapper">
          <?php get_template_part('components/section', 'recommend'); ?>
        </div>
        <div class="queryy-lower-tag-list">
          <?php get_template_part('components/list', 'tag'); ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php get_footer();
