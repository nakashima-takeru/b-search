<?php
get_header();

$searchBlogCategory = isset($_GET['cat']) ? $_GET['cat'] : '';

$s = isset($_GET['s']) ? $_GET['s'] : '';

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$search_args = [
  'post_type' => 'post',
  'post_status' => 'publish',
  'paged' => $paged,
  'posts_per_page' => 18,
];
// フリーワード検索があれば追加
if (!empty($s)) {
  $search_args['s'] = $s;
} else {
}
// タクソノミー検索があれば追加
if (!empty($searchBlogCategory)) {
  $search_args['cat'] = [
    'cat' => $searchBlogCategory,
  ];
} else {
}
$wp_query = new WP_Query($search_args);

$catArray = get_the_category();
$cat = $catArray[0] ?? null;

$downloadBanner = get_field('download_banner', $cat);
$downloadBannerInfo = [
  $downloadBanner['download_banner_value'] ?? '',
  $downloadBanner['download_banner_form_id'] ?? '',
];
$downloadBannerInfoJson = json_encode($downloadBannerInfo);
?>

<script>
  var downloadBannerInfo = JSON.parse('<?php echo $downloadBannerInfoJson; ?>');
</script>

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
                <h1 class="queryy-page-title-ja">
                  <?php if ($wp_query->have_posts()):
                    $cat_name = get_category($searchBlogCategory); ?>
                    <?php if (!empty($s)) {
                      echo '<em>「' . $s . '」</em>';
                    } ?>
                    <?php if (!empty($searchBlogCategory)) {
                      echo '<em>「' . $cat_name->name . '」</em>';
                    } ?>の記事一覧
                <?php
                  endif; ?>
                </h1>
                <div>
                  <p class="queryy-page-desc">
                    WEB制作に関する記事の一覧です。話題の最新技術やデザイン・テクニックのご紹介など、<br />
                    WEB制作に関するお役立ち情報が満載！
                  </p>
                </div>
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
          <div class="queryy-archive-list__sidebar">
            <?php
            if ($s || $searchBlogCategory):
              if ($wp_query->have_posts()): ?>
              <ul class="grid-entries">
              <?php while ($wp_query->have_posts()):

                $wp_query->the_post();
                $categories = get_the_category();
                ?>
              <li>
                <?php get_template_part('components/card', 'entry', [
                  'categories' => $categories,
                ]); ?>
              </li>
            <?php
              endwhile; ?>
          </ul>
          <?php else: ?>
            <p class="queryy-page-desc">記事が存在しません。</p>
            <?php endif;
            endif;
            wp_reset_postdata();
            ?>

            <?php get_template_part(
	              'components/download-banner-form',
	              null,
	              [
	                'downloadBanner' => $downloadBanner,
	              ]
	            ); ?>

          </div>

          <?php if (function_exists('wp_pagenavi')) {
            wp_pagenavi(['query' => $wp_query]);
          } ?>
        </div>
      </div>

      <!-- <section class="download-pickup">
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
      </section> -->

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
