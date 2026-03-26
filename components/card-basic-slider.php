<?php
$args = wp_parse_args($args, [
  'categories' => null,
  'color' => 'white',
  'counter' => 1,
]); ?>

<article class="card-basic-slider" data-color="<?php echo $args['color']; ?>">
  <a href="<?php the_permalink(); ?>" class="card-basic-slider__link">
    <div class="card-basic-slider__label">
      <span>№</span>
      <span>0<?php echo $args['counter']; ?></span>
    </div>
    <div class="stack30">
      <div class="card-basic-slider__thumbnail">
        <?php if (has_post_thumbnail()): ?>
          <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
        <?php endif; ?>
      </div>
      <div>
        <div class="card-basic-slider__head">
          <div>
            <time><?php echo esc_html(get_the_modified_date('Y.m.d')); ?></time>
          </div>
        </div>
        <div class="card-basic-slider__body stack20">
          <h3 class="card-basic-slider__title">
            <span class="text-line"><?php the_title(); ?></span>
          </h3>
          <?php if ($args['categories']): ?>
            <div class="label-category-small card-basic-slider__cat"><?php echo esc_html(
              $args['categories'][0]->name
            ); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </a>
</article>
