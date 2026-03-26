<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

<main class="queryy-main not-found stack60 sp-stack80">
  <div class="queryy-breadcrumb">
    <?php include 'partials/breadcrumbs.php'; ?>
  </div>
  <div class="not-found__inner">
    <h1 class="not-found__title">
      <span class="not-found__code">404</span>
      <span class="not-found__message">Not Found</span>
    </h1>
    <p class="not-found__lead">お探しのページが見つかりませんでした。</p>
    <div class="buttonItem not-found__button" data-color="blue">
      <a href="<?php echo esc_url(home_url()) ?>" class="buttonItem__link">
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
        メディアTOPへ戻る
      </a>
    </div>
  </div>
</main>

<?php get_footer(); ?>
