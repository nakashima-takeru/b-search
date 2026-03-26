<?php
get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$userID = get_the_author_meta('ID');
$user = get_userdata($userID);
$description = get_the_author_meta('description');

$entriesByAuthorArgs = [
  'posts_per_page' => 6,
  'paged' => $paged,
  'author' => $userID,
];

$entriesByAuthorQuery = new WP_Query($entriesByAuthorArgs);
?>

<main class="queryy-main queryy-lower-page author">
  <div class="stack60 sp-stack50">
    <div class="queryy-breadcrumb">
      <?php include 'partials/breadcrumbs.php'; ?>
    </div>
    <div>
      <div class="mainContainer">
        <div class="stack200 sp-stack150">
          <section class="author-media">
            <div class="author-media__thumbnail">
              <?php echo get_avatar($userID); ?>
            </div>
            <div class="author-media__textArea">
              <div class="author-media__header">
                <div>
                  <h1 class="author-media__name"><?php echo get_the_author_meta(
                    'display_name'
                  ); ?></h1>
                  <p class="author-media__position"><?php echo get_field(
                    'user_position',
                    $user
                  ); ?></p>
                </div>
                <div class="author-media__social">

                </div>
              </div>
              <div class="author-media__description">
                <?php echo wpautop(get_the_author_meta('description')); ?>
              </div>
            </div>
          </section>

          <section class="author-entries">
            <div class="stack40">
              <header class="entries-list-by-category__heading author-entries__heading">
                <div class="entries-list-by-category__heading-inner">
                  <h2 class="entries-list-by-category__title"><?php echo get_the_author_meta(
                    'display_name'
                  ); ?>が執筆・監修した記事</h2>
                  <div class="entries-list-by-category__meta pc">
                    <div class="entries-list-by-category__entries-count">
                      <span class="number"><?php echo $entriesByAuthorQuery->found_posts; ?></span>
                      <span>記事公開</span>
                    </div>
                  </div>
                </div>
                <div class="entries-list-by-category__meta sp">
                  <div class="entries-list-by-category__entries-count">
                    <span class="number"><?php echo $entriesByAuthorQuery->found_posts; ?></span>
                    <span>記事公開</span>
                  </div>
                </div>
              </header>
              <div class="stack100">
                <?php get_template_part(
                  'components/grid-entries',
                  null,
                  []
                ); ?>
                <?php if (function_exists('wp_pagenavi')):
                  wp_pagenavi();
                endif; ?>
              </div>
            </div>
          </section>
        </div>
      </div>

      <?php get_template_part('components/section', 'writers', [
        'userID' => $userID,
      ]); ?>

      <div class="author-latest-entries-wrapper">
        <?php get_template_part('components/section', 'latest'); ?>
      </div>

      <div class="author-ranking-slider-wrapper">
        <?php get_template_part('components/section', 'ranking'); ?>
      </div>

      <?php get_template_part('components/section', 'update'); ?>

      <div class="recommend-section-wrapper">
        <?php get_template_part('components/section', 'recommend'); ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer();
