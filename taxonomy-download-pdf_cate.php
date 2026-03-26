<?php
get_header();
$postType = $post->post_type;
$postTypeSlug = get_post_type_object($postType)->name;
$taxSlug = $postTypeSlug . '_cate';
?>

<main class="queryy-main <?php echo ' downloadPage'; ?>">
  <div class="stack60 sp-stack50">
    <?php include 'partials/breadcrumbs.php'; ?>
    <div class="stack50">
      <header class="queryy-page-header">
        <div class="queryy-page-header__inner mainContainer">
          <div class="queryy-page-header__text">
            <p class="queryy-page-title-en">Download</p>
            <h1 class="queryy-page-title-ja"><?php single_term_title(); ?>の資料ダウンロード</h1>
          </div>
        </div>
      </header>
      <div class="mainContainer">
        <div class="border-overflow-area">
          <?php get_template_part('components/list', 'taxonomy-terms', [
            'taxonomy' => $taxSlug,
          ]); ?>
        </div>
      </div>
    </div>
    <div class="downloadPage-card">
      <div class="mainContainer stack80">
        <div class="downloadPage-card__list">
          <?php
            if (have_posts()):
            while (have_posts()):
            the_post();
          ?>
            <article class="downloadPage-card__item">
                <a class="downloadPage-card__item-link hover-line-trigger"
                    href="<?php echo get_permalink(); ?>">
                    <?php
                    $term_cates = get_the_terms(get_the_ID(), $taxSlug);
                    if ($term_cates):
                      foreach ($term_cates as $term_cate): ?>
                    <div class="label-tag" data-color="blue"><?php echo $term_cate->name; ?></div>
                    <?php endforeach;
                    endif;
                    ?>
                    <div class="downloadPage-card__item-imageWrap">
                        <picture class="downloadPage-card__item-image">
                            <img src="<?php the_post_thumbnail_url(
                              'full'
                            ); ?>" alt="<?php the_title(); ?>">
                        </picture>
                    </div>
                    <h2 class="downloadPage-card__item-title">
                        <span class="hover-line-black">
                            <?php the_title(); ?>
                        </span>
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
