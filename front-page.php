<?php
get_header();
$pageTitle = get_the_title();

$latestEntriessArgs = [
  'posts_per_page' => 9,
  'orderby' => 'modified',
  'no_found_rows' => true,
];

$latestEntriesQuery = new WP_Query($latestEntriessArgs);

$twoEntriesFromLatestEntries = array_slice($latestEntriesQuery->posts ?? [], 0, 2);

$pickupItems = get_field('blog_carousel', 'option') ?: [];
$recommendEntries = get_field('blog_recommend', 'option') ? get_field('blog_recommend', 'option')['blog_recommend_repeat'] : [];

$carouselItems = [
  $pickupItems['blog_carousel1'] ?? null,
  $twoEntriesFromLatestEntries[0] ?? null,
  $pickupItems['blog_carousel2'] ?? null,
  $twoEntriesFromLatestEntries[1] ?? null,
];
?>
<main class="queryy-main">

  <?php if (array_filter($carouselItems)): ?>
    <section class="queryy-pickup" aria-label="QUERYYピックアップ記事">
    <div class="splide queryy-pickup__slider js-queryy-pickup-splide">
      <div class="queryy-pickup__slider-inner">
        <div class="splide__arrows queryy-pickup__slider-btns">
          <button class="splide__arrow splide__arrow--prev carousel-arrow-btn">
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
              <path d="M7.19998 0.799999L1.59998 4L7.19998 7.2" stroke="currentColor"/>
            </svg>
          </button>
          <button class="splide__arrow splide__arrow--next carousel-arrow-btn">
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
              <path d="M0.800024 0.799999L6.40002 4L0.800024 7.2" stroke="currentColor"/>
            </svg>
          </button>
        </div>
        <div class="splide__track queryy-pickup__slider-body">
          <ul class="splide__list">
            <?php
              $i = 1;
              foreach ($carouselItems as $item):
                if (!$item) continue;
                $terms = get_the_terms($item, 'category'); ?>
              <li class="splide__slide queryy-pickup__slide">
                <div class="media-carousel pc">
                  <div class="media-carousel__wrapper">
                    <div class="media-carousel__text-area">
                      <div class="media-carousel__head">
                        <span class="media-carousel__label">
                          <span>Pick Up</span>
                          <span><?php echo sprintf('%02d', $i); ?></span>
                        </span>
                        <?php if ($terms):
                          foreach ($terms as $term): ?>
                          <div class="media-carousel__category label-category-small"><?php echo $term->name; ?></div>
                        <?php endforeach;
                        endif; ?>
                      </div>
                      <h2 class="media-carousel__title"><?php echo $item->post_title; ?></h2>


                      <div class="media-carousel__btn">
                        <div class="buttonItem" data-color="blue">
                          <a href="<?php echo get_permalink(
                            $item->ID
                          ); ?>" class="buttonItem__link">
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
                            もっと見る
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="media-carousel__thumbnail">
                      <?php echo get_the_post_thumbnail($item->ID, 'full'); ?>
                    </div>
                  </div>
                </div>
                <div class="media-carousel sp">
                  <a href="<?php echo get_permalink($item->ID); ?>">
                    <div class="media-carousel__wrapper">
                      <div class="media-carousel__text-area">
                        <div class="media-carousel__head">
                          <span class="media-carousel__label">
                            <span>Pick Up</span>
                            <span><?php echo sprintf('%02d', $i); ?></span>
                          </span>
                          <?php if ($terms):
                            foreach ($terms as $term): ?>
                            <div class="media-carousel__category label-category-small"><?php echo $term->name; ?></div>
                          <?php endforeach;
                          endif; ?>
                        </div>
                        <h2 class="media-carousel__title"><?php echo $item->post_title; ?></h2>
                      </div>
                      <div class="media-carousel__thumbnail">
                        <?php echo get_the_post_thumbnail($item->ID, 'full'); ?>
                      </div>
                    </div>
                  </a>
                </div>
              </li>
            <?php
              $i++;
              endforeach;
            ?>
          </ul>
        </div>
      </div>
      <ul class="splide__pagination carousel-pagination queryy-pickup__slider-pagination"></ul>
    </div>
  </section>
  <?php endif; ?>

  <section class="entries-section queryy-latest">
    <div class="mainContainer stack40">
      <div class="border-overflow-area queryy-latest__heading">
        <header class="section-titleArea-2">
          <p class="section-titleArea-2__title">Latest</p>
          <h2 class="section-titleArea-2__subtitle">新着記事</h2>
        </header>
        <?php get_template_part('components/list', 'category'); ?>
      </div>

      <div class="entries-section__inner stack40">
        <?php get_template_part('components/grid-entries', null, [
          'query' => $latestEntriesQuery,
        ]); ?>
        <div class="entries-section__button">
          <div class="buttonItem" data-color="blue">
            <a href="<?php echo esc_url(home_url('/articles')) ?>" class="buttonItem__link">
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
              記事一覧を見る
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="queryy-category-entries">
    <div class="mainContainer stack40">
      <div class="border-overflow-area">
        <header class="section-titleArea-2">
          <p class="section-titleArea-2__title">Categories</p>
          <p class="section-titleArea-2__subtitle">カテゴリ別記事</p>
        </header>
      </div>

      <div class="stack40">
        <?php
          // カテゴリー別記事設定、ページID取得
          $front_id = get_option('page_on_front');
          $post_id_for_acf = $front_id ?: get_the_ID();
          if ( have_rows('front_category_sections', $post_id_for_acf) ):
            while( have_rows('front_category_sections', $post_id_for_acf) ): the_row();

            $term = get_sub_field('category');
            if ( !$term || !($term instanceof WP_Term) ) {
              continue;
            }

            // キャッチコピーの取得
            $catchcopy = get_field('catchcopy', $term);
            $title = $catchcopy ?: $term->name;

            // 記事公開数
            $published_count = $term->count;

            // 表示件数
            $ppp = get_sub_field('posts_per_page');
            if ( $ppp <= 0 ) $ppp = 3;

            $category_section_query = new WP_Query([
              'post_type' => 'post',
              'post_status' => 'publish',
              'posts_per_page' => $ppp,
              'ignore_sticky_posts' => true,
              'category__in' => $term->term_id,
            ]);

            // 遷移先
            $term_link = get_term_link($term);

            // 記事数が0ならセクション自体出さない
            if ( !$category_section_query->have_posts() ) {
              wp_reset_postdata();
              continue;
            }
          ?>
            <section class="entries-section entries-list-by-category stack40 sp-stack20">
              <header class="entries-list-by-category__heading">
                <div class="entries-list-by-category__heading-inner">
                  <h2 class="entries-list-by-category__title"><?php echo esc_html($title); ?></h2>
                  <div class="entries-list-by-category__meta pc">
                    <div class="category-item">
                      <span class="category-item__circle"></span>
                      <p class="category-item__name large"><?php echo esc_html($term->name); ?></p>
                    </div>
                    <div class="entries-list-by-category__entries-count">
                      <span class="number"><?php echo esc_html($published_count); ?></span>
                      <span>記事公開</span>
                    </div>
                  </div>
                </div>
                <div class="entries-list-by-category__meta sp">
                  <div class="category-item">
                    <span class="category-item__circle"></span>
                    <p class="category-item__name large"><?php echo esc_html($term->name); ?></p>
                  </div>
                  <div class="entries-list-by-category__entries-count">
                    <span class="number"><?php echo esc_html($published_count); ?></span>
                    <span>記事公開</span>
                  </div>
                </div>
              </header>
              <div class="entries-section__inner stack40">
                <?php get_template_part('components/grid-entries', null, [
                  'query' => $category_section_query,
                ]); ?>
                <div class="entries-section__button">
                  <div class="buttonItem" data-color="blue">
                    <a href="<?php echo esc_url($term_link) ?>" class="buttonItem__link">
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
                      <?php echo esc_html($term->name . '記事一覧を見る'); ?>
                    </a>
                  </div>
                </div>
              </div>
            </section>
          <?php
            endwhile;
            endif;
          ?>
      </div>
    </div>
  </section>

  <div class="queryy-ranking-basic-wrapper">
    <?php get_template_part('components/section', 'ranking'); ?>
  </div>

  <div class="queryy-top-recommend">
    <?php get_template_part('components/section', 'recommend'); ?>
  </div>

  <?php get_template_part('components/section', 'update'); ?>

  <div class="queryy-top-tag-list">
    <?php get_template_part('components/list', 'tag'); ?>
  </div>
</main>
<?php get_footer();
