<?php
get_header();
$current_term = get_queried_object();
$catArray = get_the_category();
$cat = $catArray[0] ?? null;
$taxSlug = 'category';
$termId = $cat ? $cat->cat_ID : null;
$termName = $cat ? $cat->cat_name : null;
$cta = $cat ? get_field('cta', $cat) : null;

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
                <h1 class="queryy-page-title-ja"><em><?php echo single_cat_title(); ?></em>の記事一覧</h1>
                <div class="queryy-page-desc">
                  <?php echo category_description(); ?>
                </div>
              </div>
              <?php if (
                !empty($cta['cta_button_title']) &&
                !empty($cta['cta_button_url']['url'])
              ): ?>
                <!-- <div class="queryy-page-header__cta">
                  <?php get_template_part('components/button', 'regular', [
                    'text' => $cta['cta_button_title'],
                    'url' => $cta['cta_button_url']['url'],
                    'color' => 'blue',
                    'isLink' => true,
                  ]); ?>
                </div> -->
              <?php endif; ?>
            </div>
          </header>
          <div class="mainContainer">
            <div class="border-overflow-area">
              <?php get_template_part('components/list', 'category', [
                'current_category_id' => $termId,
              ]); ?>
            </div>
          </div>
        </div>
        <div class="stack100 mainContainer queryy-archive-list">
          <div class="queryy-archive-list__sidebar">
	            <?php get_template_part('components/grid-entries', null, [
	              'query' => null,
	            ]); ?>
	            <?php get_template_part(
	              'components/download-banner-form',
	              null,
	              [
	                'downloadBanner' => $downloadBanner,
	              ]
	            ); ?>
          </div>
          <?php wp_pagenavi(); ?>
        </div>
      </div>
    </div>
  </div>

  <!-- download-pdf -->
  <!-- <?php
  $downloadItems = get_field('select_download-pdf', $cat);
  if ($downloadItems): ?>
    <section class="download-pickup">
      <div class="mainContainer">
        <header class="section-titleArea">
          <div class="section-titleArea__en">Download</div>
          <h2 class="section-titleArea__jp">お役立ち資料ダウンロード</h2>
        </header>
        <div class="download-pickup__list">
          <?php foreach ($downloadItems as $item): ?>
            <?php get_template_part('components/card', 'download', [
              'id' => $item->ID,
            ]); ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif;
  ?> -->

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
</main>
<?php get_footer();
