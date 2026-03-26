<?php
$args = wp_parse_args($args, [
  'text' => '',
  'url' => '',
  'color' => 'white',
  'isLink' => false,
]); ?>

<div class="buttonItem" data-color="<?php echo $args['color']; ?>">
  <?php if ($args['isLink']): ?>
    <a href="<?php echo $args['url']; ?>" class="buttonItem__link">
  <?php else: ?>
    <span class="buttonItem__link">
  <?php endif; ?>
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
    <?php echo $args['text']; ?>
  <?php if ($args['isLink']): ?>
    </a>
  <?php else: ?>
    </span>
  <?php endif; ?>
</div>
