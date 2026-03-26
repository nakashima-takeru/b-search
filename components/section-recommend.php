<?php
$blog_recommend = get_field('blog_recommend', 'option') ?? [];
$recommendEntries =  $blog_recommend['blog_recommend_repeat'] ?? [];
?>

<section class="queryy-recommend">
  <div class="mainContainer stack50">
    <div class="border-overflow-area">
      <header class="section-titleArea-2">
        <p class="section-titleArea-2__title">Recommend</p>
        <h2 class="section-titleArea-2__subtitle">おすすめ記事</h2>
      </header>
    </div>
    <div class="entries-section__inner">
      <ul class="grid-entries with-line queryy-recommend__grid">
        <?php if ($recommendEntries):
          foreach ($recommendEntries as $entry):
            if (empty($entry['blog_recommend_item'])) continue;

            $post = $entry['blog_recommend_item'];
            setup_postdata($post);
            $categories = get_the_category();
            ?>
          <li class="media-small grid-entries__item">
            <a href="<?php the_permalink(); ?>" class="media-small__link">
              <div class="media-small__thumbnail">
                <img src="<?php the_post_thumbnail_url('medium_large'); ?>"
                alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
              </div>
              <div class="media-small__text-area">
                <div class="media-small__head">
                  <div>
                    <time><?php echo esc_html(get_the_modified_date('Y.m.d')); ?></time>
                  </div>
                </div>
                <div class="media-small__body">
                  <h3 class="media-small__title">
                    <span class="text-line"><?php the_title(); ?></span>
                  </h3>
                  <?php if ($categories): ?>
                    <div class="label-category-small media-small__cat"><?php echo esc_html($categories[0]->name); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </li>
        <?php
          endforeach;
          wp_reset_postdata();
        endif; ?>
      </ul>
    </div>
  </div>
</section>
