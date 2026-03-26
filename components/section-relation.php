<?php
$args = wp_parse_args($args, [
  'color' => 'white',
  'post_id' => null,
  'tags' => null,
  'category' => null,
]);

$counter = 1;
$baseArgs = [
  'post_type' => 'post',
  'posts_per_page' => 10,
  'post__not_in' => [$args['post_id']],
  'no_found_rows' => true,
];
$relationEntriesArgs = [];

if (!empty($args['tags'])) {
  $tag_counts = array_column($args['tags'], 'count');
  array_multisort($tag_counts, SORT_DESC, $args['tags']);
  $relationEntriesArgs = array_merge($baseArgs, [
    'tag_id' => $args['tags'][0]->term_id,
  ]);
} elseif (!empty($args['category'])) {
  $relationEntriesArgs = array_merge($baseArgs, [
    'cat' => $args['category']->cat_ID,
  ]);
} else {
  $relationEntriesArgs = array_merge($baseArgs, [
    'post__in' => [],
  ]);
}

$relationEntriesQuery = new WP_Query($relationEntriesArgs);
?>

<?php if ($relationEntriesQuery && $relationEntriesQuery->have_posts()): ?>
<section class="queryy-basic-slider splide js-queryy-basic-slider">
  <div class="mainContainer queryy-basic-slider__wrapper stack40">
    <div class="border-overflow-area queryy-basic-slider__header">
      <header class="section-titleArea-2">
        <p class="section-titleArea-2__title">Relation</p>
        <h2 class="section-titleArea-2__subtitle">関連記事</h2>
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
          <?php
          while ($relationEntriesQuery->have_posts()):

            $relationEntriesQuery->the_post();
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
          endwhile;
          wp_reset_postdata();
          ?>
        </ul>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
