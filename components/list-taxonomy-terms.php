<?php
$args = wp_parse_args($args ?? [], [
  'taxonomy' => '',
  'term_query_args' => [],
  'terms' => null,
  'current_term_id' => null,
]);

$taxonomy = is_string($args['taxonomy']) ? $args['taxonomy'] : '';
if ($taxonomy === '') {
  return;
}

$current_term_id = $args['current_term_id'];
if ($current_term_id === null) {
  $current_term_id = is_tax($taxonomy) ? get_queried_object_id() : 0;
}

$terms = $args['terms'];
if ($terms === null) {
  $term_query_args = array_merge(
    [
      'taxonomy' => $taxonomy,
      'hide_empty' => true,
    ],
    is_array($args['term_query_args']) ? $args['term_query_args'] : []
  );
  $terms = get_terms($term_query_args);
}

if (is_wp_error($terms)) {
  $terms = [];
}

$items = [];

foreach ($terms as $term) {
  if (!($term instanceof WP_Term)) {
    continue;
  }
  $term_link = get_term_link($term, $taxonomy);
  if (is_wp_error($term_link)) {
    continue;
  }
  $items[] = [
    'url' => $term_link,
    'label' => $term->name,
    'active' => (absint($current_term_id) === absint($term->term_id)),
  ];
}

$base_args = [
  'items' => $items,
  'ul_class' => 'category-list',
  'link_class' => 'category-item link',
  'active_class' => 'active',
  'name_class' => 'category-item__name',
];
get_template_part('components/list-category-base', null, $base_args);
