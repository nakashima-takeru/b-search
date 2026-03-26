<?php
get_header();
$current_term = get_queried_object();
$tag = get_queried_object();
$taxSlug = 'post_tag';
$termId = $tag->term_id;
$termName = $tag->name;
$cta = get_field('cta', $tag);

$downloadBanner = get_field('download_banner', $tag);
$downloadBannerInfoJson = null;
if (
  $downloadBanner['download_banner_value'] &&
  $downloadBanner['download_banner_form_id']
) {
  $downloadBannerInfoJson = json_encode([
    $downloadBanner['download_banner_value'],
    $downloadBanner['download_banner_form_id'],
  ]);
}
?>

<?php if ($downloadBannerInfoJson): ?>
  <script>
    var downloadBannerInfo = JSON.parse('<?php echo $downloadBannerInfoJson; ?>');
  </script>
<?php endif; ?>

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
                <h1 class="queryy-page-title-ja"><em><?php echo single_tag_title(); ?></em>の記事一覧</h1>
                <div class="queryy-page-desc">
                  <?php if (tag_description()) {
                    echo tag_description();
                  } else {
                    echo 'WEB制作に関する記事の一覧です。話題の最新技術やデザイン・テクニックのご紹介など、WEB制作に関するお役立ち情報が満載！';
                  } ?>
                </div>
              </div>
              <?php if (
                $cta['cta_button_title'] &&
                $cta['cta_button_url']['url']
              ): ?>
                <div class="queryy-page-header__cta">
                  <?php get_template_part('components/button', 'regular', [
                    'text' => $cta['cta_button_title'],
                    'url' => $cta['cta_button_url']['url'],
                    'color' => 'blue',
                    'isLink' => true,
                  ]); ?>
                </div>
              <?php endif; ?>
            </div>
          </header>
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
  <?php
  $downloadItems = get_field('select_download-pdf', $tag);
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
  ?>

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
<?php get_footer(); ?>
