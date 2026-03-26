<?php
$args = wp_parse_args($args, [
  'categories' => null,
]); ?>

<article class="card-entry">
  <a href="<?php the_permalink(); ?>" class="card-entry__link">
    <div class="card-entry__thumbnail">
      <?php echo get_the_post_thumbnail(get_the_ID(), 'medium_large', [
        'alt' => get_the_title(),
      ]); ?>
    </div>
    <div class="card-entry__textArea">
      <div class="card-entry__head">
        <time><?php echo esc_html(get_the_modified_date('Y.m.d')); ?></time>
        <?php if (is_new_badge_needed()): ?>
          <div class="card-entry__badge">
            <p>New</p>
          </div>
        <?php endif; ?>
      </div>
      <h3 class="card-entry__title">
        <span class="text-line"><?php the_title(); ?></span>
      </h3>
      <?php if ($args['categories']): ?>
        <div class="label-category-small card-entry__cat"><?php echo esc_html(
          $args['categories'][0]->name
        ); ?></div>
      <?php endif; ?>
    </div>
  </a>
</article>
