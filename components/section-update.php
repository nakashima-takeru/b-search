<?php
$updateEntriesArgs = [
  'posts_per_page' => 12,
  'orderby' => 'modified',
  'no_found_rows' => true,
];

$updateEntriesQuery = new WP_Query($updateEntriesArgs);
$updateEntries = array_chunk($updateEntriesQuery->posts ?? [], 4);
?>

<section class="queryy-update">
  <div class="mainContainer queryy-update__inner stack50">
    <div class="border-overflow-area">
      <header class="section-titleArea-2">
        <p class="section-titleArea-2__title">Update</p>
        <h2 class="section-titleArea-2__subtitle">最新の更新記事</h2>
      </header>
    </div>
    <div class="splide js-queryy-update-splide">
      <div class="queryy-update__slider-inner">
        <div class="splide__arrows queryy-update__slider-btns">
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
        <div class="splide__track">
          <div class="splide__list queryy-update__slider-list">
            <?php if ( !empty(array_filter($updateEntries)) ):
              foreach ($updateEntries as $entiesChunk): ?>
              <ul class="splide__slide grid-entries with-line queryy-recommend__grid">
                <?php if ( !empty(array_filter($entiesChunk)) ):
                  foreach ($entiesChunk as $post):
                    if (!$post) continue;
                    setup_postdata($post);
                    $categories = get_the_category();
                  ?>
                  <li class="media-small grid-entries__item">
                    <a href="<?php the_permalink(); ?>" class="media-small__link">
                      <div class="media-small__thumbnail">
                        <?php if (has_post_thumbnail()): ?>
                          <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                        <?php endif; ?>
                      </div>
                      <div class="media-small__text-area">
                        <div class="media-small__head">
                          <div>
                            <time><?php echo esc_html(
                              get_the_modified_date('Y.m.d')
                            ); ?></time>
                          </div>
                        </div>
                        <div class="media-small__body">
                          <h3 class="media-small__title">
                            <span class="text-line"><?php the_title(); ?></span>
                          </h3>
                          <?php if ($categories): ?>
                            <div class="label-category-small media-small__cat"><?php echo esc_html(
                              $categories[0]->name
                            ); ?></div>
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
            <?php endforeach;
            endif; ?>
          </div>
        </div>
      </div>
      <ul class="splide__pagination carousel-pagination queryy-update__slider-pagination"></ul>
    </div>
  </div>
</section>
