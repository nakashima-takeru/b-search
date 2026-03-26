<?php
$args = wp_parse_args($args ?? [], [
  'items' => [],
  'ul_class' => 'category-list',
  'link_class' => 'category-item link',
  'active_class' => 'active',
  'name_class' => 'category-item__name',
  'name_size' => null,
]);

$items = is_array($args['items']) ? $args['items'] : [];

$name_class = trim(
  $args['name_class'] . ($args['name_size'] ? ' ' . $args['name_size'] : '')
);
?>

<?php if (!empty($items)): ?>
  <ul class="<?php echo esc_attr($args['ul_class']); ?>">
    <?php foreach ($items as $item):
      if (!is_array($item)) {
        continue;
      }
      $url = isset($item['url']) && is_string($item['url']) ? $item['url'] : '';
      $label = isset($item['label']) && is_string($item['label']) ? $item['label'] : '';
      if ($url === '' || $label === '') {
        continue;
      }
      $is_active = !empty($item['active']);
      ?>
      <li>
        <a
          href="<?php echo esc_url($url); ?>"
          class="<?php echo esc_attr(
            trim(
              $args['link_class'] .
                ($is_active ? ' ' . $args['active_class'] : '')
            )
          ); ?>"
        >
          <span class="category-item__circle"></span>
          <p class="<?php echo esc_attr($name_class); ?>">
            <?php echo esc_html($label); ?>
          </p>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

