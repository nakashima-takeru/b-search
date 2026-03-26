<?php
get_header();
$pageTitle = get_the_title();
?>
<main class="queryy-main queryy-lower-page">
  <div class="stack60 sp-stack50">
    <?php if ( have_posts() ):
      while( have_posts() ):
      the_post();
    ?>
      <div class="queryy-breadcrumb">
        <?php include 'partials/breadcrumbs.php'; ?>
      </div>
      <article class="stack30">
        <header class="queryy-page-header">
          <div class="queryy-page-header__inner mainContainer">
            <div class="queryy-page-header__text">
              <h1 class="queryy-page-title-en"><?php the_title(); ?></h1>
            </div>
          </div>
        </header>
        <div class="mainContainer page-content">
          <?php the_content(); ?>
        </div>
      </article>
    <?php
      endwhile;
      endif;
    ?>
  </div>
</main>
<?php get_footer(); ?>
