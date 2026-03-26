<?php
$args = wp_parse_args($args, [
  'query' => null,
]);

$the_query = $args['query'] ? $args['query'] : $wp_query;
?>

<ul class="grid-entries">
  <?php if ($the_query->have_posts()):
    while ($the_query->have_posts()):

      $the_query->the_post();
      $categories = get_the_category();
      ?>
    <li>
      <?php get_template_part('components/card', 'entry', [
        'categories' => $categories,
      ]); ?>
    </li>
  <?php
    endwhile;
    wp_reset_postdata();
  endif; ?>
</ul>
