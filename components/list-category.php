<?php
$args = wp_parse_args($args ?? [], [
  'current_category_id' => null,
]);

$categories = get_categories();

$items = [];
if ($categories) {
  foreach ($categories as $category) {
    if (!($category instanceof WP_Term)) {
      continue;
    }
    $category_link = get_category_link($category->term_id);
    if (is_wp_error($category_link)) {
      continue;
    }
    $items[] = [
      'url' => $category_link,
      'label' => $category->name,
      'active' => (absint($args['current_category_id']) === absint($category->term_id)),
    ];
  }
}

$base_args = [
  'items' => $items,
  'ul_class' => 'category-list',
  'link_class' => 'category-item link',
  'active_class' => 'active',
  'name_class' => 'category-item__name',
];
get_template_part('components/list-category-base', null, $base_args);
