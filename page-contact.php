<?php
/*
  Template Name: contact
*/

remove_filter('the_content', 'wpautop');

get_header();
?>

<main id="content" class="queryy-main">
  <div class="stack60 sp-stack50">
    <p id="brdcrmb"><a href="<?php echo get_bloginfo('url'); ?>/">TOP</a>お問い合わせ</p>
    <div class="contact__container">
      <header class="queryy-page-header">
        <div class="queryy-page-header__inner mainContainer">
          <div class="queryy-page-header__text">
            <p class="queryy-page-title-en">CONTACT</p>
            <h1 class="queryy-page-title-ja">採用に関する問い合わせ</h1>
          </div>
        </div>
      </header>
      
      <div class="contact__wrap">
        <?php if (have_posts()) : ?>
          <div id="contact" class="content_innr">
            <?php while (have_posts()) : the_post(); ?>
              <?php the_content(); ?>
            <?php endwhile; ?>

            <p class="contact__policyLink">送信することで、<span><a href="<?php echo esc_url(home_url('/policy')) ?>">プライバシーポリシー</a></span>に同意したものとします。</p>
          </div><!--content_innr-->
        <?php endif; ?>
        <?php wp_reset_query(); ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
