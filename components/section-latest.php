<?php
$args = wp_parse_args($args, [
  'color' => 'gray',
]);

$counter = 1;
$latestEntriesArgs = [
  'post_type' => 'post',
  'posts_per_page' => 5,
  'no_found_rows' => true,
];

$latestEntriesQuery = new WP_Query($latestEntriesArgs);
?>

<?php if ($latestEntriesQuery && $latestEntriesQuery->have_posts()): ?>
<section class="queryy-basic-slider splide js-queryy-basic-slider">
    <div class="mainContainer queryy-basic-slider__wrapper stack40">
      <div class="border-overflow-area queryy-basic-slider__header">
        <header class="section-titleArea-2">
          <p class="section-titleArea-2__title">Pick up</p>
          <h2 class="section-titleArea-2__subtitle">新着特集</h2>
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
            while ($latestEntriesQuery->have_posts()):

              $latestEntriesQuery->the_post();
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
