<?php
/*
  Template Name: サンクスページ
  Template Post Type: page
*/

get_header();

$title_jp = function_exists('get_field')
  ? get_field('title_jp')
  : get_post_meta(get_the_ID(), 'title_jp', true);

$lead_text = function_exists('get_field')
  ? get_field('lead_text')
  : get_post_meta(get_the_ID(), 'lead_text', true);
?>

<main class="queryy-main thanks-page">
  <div class="thanks-page__inner mainContainer">
    <p class="thanks-page__title-en">Thank You</p>

    <?php if ( !empty($title_jp) ): ?>
      <h1 class="thanks-page__title-ja">
        <?php echo esc_html($title_jp); ?>
      </h1>
    <?php endif; ?>

    <?php if ( !empty($lead_text) ): ?>
      <div class="thanks-page__desc">
        <?php echo wpautop(esc_html($lead_text)); ?>
      </div>
    <?php endif; ?>

    <div class="buttonItem thanks-page__button" data-color="blue">
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

