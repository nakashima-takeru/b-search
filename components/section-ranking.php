<?php
$args = wp_parse_args($args, [
  'color' => 'white',
]);

$counter = 1;
$rankingEntriesArgs = [
  'post_type' => 'post',
  'posts_per_page' => 8,
  'meta_key' => 'views',
  'orderby' => 'meta_value_num',
  'order' => 'DESC',
  'no_found_rows' => true,
];

$blogRanking = get_field('blog_ranking', 'option');
$blogRankingMode = $blogRanking['blog_ranking_mode'] ?? null;
$rankingEntries = [];
$rankingEntriesQuery = null;

if ($blogRankingMode === 'optional') {
  $rankingEntries = $blogRanking['blog_ranking_optional_repeat'] ?? [];
} elseif ($blogRankingMode === 'ranking') {
  $rankingEntriesQuery = new WP_Query($rankingEntriesArgs);
}
?>

<?php if (
  !empty(array_filter($rankingEntries)) ||
  ($rankingEntriesQuery && $rankingEntriesQuery->have_posts())
): ?>
  <section class="queryy-basic-slider splide js-queryy-basic-slider">
    <div class="mainContainer queryy-basic-slider__wrapper stack40">
      <div class="border-overflow-area queryy-basic-slider__header">
        <header class="section-titleArea-2">
          <p class="section-titleArea-2__title">Ranking</p>
          <h2 class="section-titleArea-2__subtitle">アクセスランキング</h2>
        </header>
        <div class="splide__arrows queryy-basic-slider__btns">
          <button class="splide__arrow splide__arrow--prev carousel-arrow-btn white">
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
              <path d="M7.19998 0.799999L1.59998 4L7.19998 7.2" stroke="currentColor"/>
            </svg>
          </button>
          <button class="splide__arrow splide__arrow--next carousel-arrow-btn white">
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
              <path d="M0.800024 0.799999L6.40002 4L0.800024 7.2" stroke="currentColor"/>
            </svg>
          </button>
        </div>
      </div>
      <div class="queryy-basic-slider__inner">
        <div class="splide__track">
          <ul class="splide__list">
            <?php if ($blogRankingMode === 'optional'):
              foreach ($rankingEntries as $entry):
                if (empty($entry['blog_ranking_optional_item'])) continue;

                $post = $entry['blog_ranking_optional_item'];
                setup_postdata($post);
                $categories = get_the_category();
                ?>
              <li class="splide__slide">
                <?php get_template_part(
                  'components/card',
                  'basic-slider',
                  [
                    'categories' => $categories,
                    'color' => $args['color'],
                    'counter' => $counter,
                  ]
                ); ?>
              </li>
            <?php $counter++;
              endforeach;
              wp_reset_postdata();
            elseif ($blogRankingMode === 'ranking'):
              while ($rankingEntriesQuery->have_posts()):

                $rankingEntriesQuery->the_post();
                $categories = get_the_category();
                ?>
              <li class="splide__slide">
                <?php get_template_part(
                  'components/card',
                  'basic-slider',
                  [
                    'categories' => $categories,
                    'color' => $args['color'],
                    'counter' => $counter,
                  ]
                ); ?>
              </li>
            <?php $counter++;
              endwhile;
              wp_reset_postdata();
            endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
<?php endif;
?>
