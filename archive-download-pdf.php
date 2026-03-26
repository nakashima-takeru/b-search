<?php
get_header();
$postType = (isset($post) && is_object($post) && isset($post->post_type)) ? $post->post_type : get_post_type();
$post_type_obj = get_post_type_object($postType);
$postTypeSlug = (is_object($post_type_obj) && isset($post_type_obj->name)) ? $post_type_obj->name : 'download-pdf';

$taxName = $postTypeSlug . '_cate';
$pageTitle = post_type_archive_title('', false);

$archive_lead = get_field('download_archive_lead', 'option');

?>
<main class="queryy-main <?php echo ' downloadPage'; ?>">
  <div class="stack60 sp-stack50">
    <?php include 'partials/breadcrumbs.php'; ?>
    <div class="stack80">
      <div class="stack50">
        <header class="queryy-page-header">
          <div class="queryy-page-header__inner mainContainer">
            <div class="queryy-page-header__text">
              <p class="queryy-page-title-en">Download</p>
              <h1 class="queryy-page-title-ja">お役立ち資料ダウンロード</h1>
              <?php if ($archive_lead): ?>
                <div class="queryy-page-desc">
                  <?php echo wpautop( esc_html($archive_lead) ); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </header>
        <div class="mainContainer">
          <div class="border-overflow-area">
            <?php
              get_template_part('components/list', 'taxonomy-terms', [
                'taxonomy' => $taxName,
              ]);
            ?>
          </div>
      </div>
    </div>

    <div class="download-pickup">
      <div class="mainContainer">
        <?php if (have_rows('download_pickup', 'option')): ?>
        <div class="download-pickup__list">
            <?php while (have_rows('download_pickup', 'option')):
              the_row();
              $post_pickup = get_sub_field('download_pickup_item');
              $post_pickupID = $post_pickup->ID;
            ?>
            <article class="download-pickup-item">
                <a
                  class="download-pickup-item__link hover-line-trigger"
                  href="<?php echo get_permalink($post_pickupID);?>"
                >
                  <?php
                    $term_cates = get_the_terms(
                      $post_pickupID,
                      $taxName
                    );
                    if ($term_cates): ?>
                    <div class="download-pickup-item__tag-list">
                    <?php
                      foreach ($term_cates as $term_cate):
                        // オブジェクトかどうかをチェックしてからnameプロパティにアクセス
                        if (is_object($term_cate) && isset($term_cate->name)): ?>
                          <div class="label-tag"><?php echo $term_cate->name; ?></div>
                    <?php
                      endif;
                      endforeach;
                    ?>
                    </div>
                    <?php endif; ?>
                    <div class="download-pickup-item__imageWrap">
                        <picture class="download-pickup-item__image">
                          <?php if (
                            has_post_thumbnail($post_pickupID)
                          ) {
                            echo get_the_post_thumbnail(
                              $post_pickupID
                            );
                          } ?>
                        </picture>
                    </div>
                    <h3 class="download-pickup-item__title">
                        <span class="hover-line-white"><?php echo get_the_title(
                          $post_pickupID
                        ); ?></span>
                    </h3>
                    <div class="download-pickup-item__btn">
                        <div class="buttonItem" data-color="white">
                            <span class="buttonItem__link">
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
                                詳細を見る
                            </span>
                        </div>
                    </div>
                </a>
            </article>
            <?php
            endwhile; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="downloadPage-card">
      <div class="mainContainer stack80">
        <div class="downloadPage-card__list">
          <?php
            if (have_posts()):
            while (have_posts()):
            the_post();
            $pageID = get_the_ID();
          ?>
          <article class="downloadPage-card__item">
            <a
              class="downloadPage-card__item-link hover-line-trigger"
              href="<?php echo get_permalink(); ?>"
            >
              <?php
                $term_cates = get_the_terms($pageID, $taxName);
                if ($term_cates):
                foreach ($term_cates as $term_cate):
                // オブジェクトかどうかをチェックしてからnameプロパティにアクセス
                if (is_object($term_cate) && isset($term_cate->name)):
              ?>
                <div class="label-tag" data-color="blue"><?php echo $term_cate->name; ?></div>
              <?php endif; ?>
              <?php
                endforeach;
                endif;
              ?>
              <div class="downloadPage-card__item-imageWrap">
                <?php if (has_post_thumbnail()) {
                  echo get_the_post_thumbnail();
                } ?>
              </div>
              <h2 class="downloadPage-card__item-title">
                <span class="hover-line-black"><?php echo get_the_title(); ?></span>
              </h2>
              <div class="downloadPage-card__item-btn">
                  <div class="buttonItem" data-color="white">
                      <span class="buttonItem__link">
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
                          詳細を見る
                      </span>
                  </div>
              </div>
            </a>
          </article>
            <?php
            endwhile;
            wp_reset_postdata();
            endif;
            ?>
        </div>

        <?php if (function_exists('wp_pagenavi')) {
          wp_pagenavi();
        } ?>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>
