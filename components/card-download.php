<?php
$args = wp_parse_args($args, [
  'id' => null,
]);

$title = get_the_title($args['id']);
?>

<article class="download-pickup-item">
  <a
    href="<?php echo get_permalink($args['id']); ?>"
    class="download-pickup-item__link hover-line-trigger"
  >
    <?php
    $term_cates = get_the_terms($args['id'], 'download-pdf_cate');

    if ($term_cates): ?>
      <div class="download-pickup-item__tag-list">
        <?php foreach ($term_cates as $term_cate): ?>
            <div class="label-tag"><?php echo $term_cate->name; ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif;
    ?>
    <?php if (has_post_thumbnail($args['id'])): ?>
      <div class="download-pickup-item__image">
        <?php echo get_the_post_thumbnail($args['id'], 'medium_large', [
          'loading' => 'lazy',
        ]); ?>
      </div>
    <?php endif; ?>
    <h3 class="download-pickup-item__title">
      <span class="hover-line-white">
        <?php echo esc_html($title); ?>
      </span>
    </h3>
    <div class="download-pickup-item__btn">
      <div class="buttonItem" data-color="white">
        <span class="buttonItem__link">
          <span class="buttonItem__ico">
            <span class="buttonItem__ico--enter">
              <svg class="svg-arrow" astro-icon="arrow">
                <use xlink:href="#astroicon:arrow"></use>
              </svg>
            </span>
            <span class="buttonItem__ico--leave">
              <svg class="svg-arrow" astro-icon="arrow">
                <use xlink:href="#astroicon:arrow"></use>
              </svg>
            </span>
          </span>
          詳細を見る
        </span>
      </div>
    </div>
  </a>
</article>
