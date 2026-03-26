<?php
get_header();
$no = 12;
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = [
  'number' => $no,
  'paged' => $paged,
  'orderby' => 'post_count',
  'order' => 'DESC',
  'meta_query' => [
    'relation' => 'AND',
    [
      'key' => 'user_slug',
      'compare' => 'EXISTS',
    ],
    [
      'key' => 'user_slug',
      'value' => '',
      'compare' => '!=',
    ],
  ],
];

$wp_user_query = new WP_User_Query($args);
?>

<main class="queryy-main queryy-lower-page">
  <div class="stack60 sp-stack50">
    <div class="queryy-breadcrumb">
      <?php include 'partials/breadcrumbs.php'; ?>
    </div>
    <div class="stack80">
      <div class="stack50">

        <header class="queryy-page-header">
          <div class="queryy-page-header__inner mainContainer">
            <div class="queryy-page-header__text">
              <p class="queryy-page-title-en">Authors</p>
              <h1 class="queryy-page-title-ja">著者・監修者一覧</h1>
              <div>
                <p class="queryy-page-desc">本サイトの執筆陣をご紹介いたします。</p>
              </div>
            </div>
          </div>
        </header>

        <div class="mainContainer">
          <div class="border-overflow-area"></div>
        </div>
      </div>

      <div class="mainContainer queryy-archive-list">
        <div class="stack100">
          <?php if ($wp_user_query->get_total() > 0): ?>
            <ul class="writers-grid">
              <?php foreach ($wp_user_query->get_results() as $user):
                $user_position = get_field('user_position', $user); ?>
                <li class="writers-grid__item">

                  <div class="writer-item">
                    <a href="<?php echo esc_url(home_url('/writers')); ?>/<?php echo $user->user_nicename; ?>" class="writer-item__link">
                      <div class="writer-item__thumbnail">
                        <?php echo get_avatar($user->ID); ?>
                      </div>
                      <h2 class="writer-item__name"><?php echo $user->display_name; ?></h2>
                      <?php if ($user_position): ?>
                        <p class="writer-item__position"><?php echo get_field(
                          'user_position',
                          $user
                        ); ?></p>
                      <?php endif; ?>
                    </a>
                  </div>
                </li>
              <?php
              endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php
          $total_users = $wp_user_query->total_users;
          $total_pages = ceil($total_users / $no);

          // ページネーション
          $big = 999999999;

          $navs = paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '/writers/page/%#%',
            'current' => max(1, $paged),
            'total' => $total_pages,
            'prev_next' => false,
            'type' => 'array',
          ]);
          ?>
          <?php if ($navs): ?>
            <div class="queryy-pagination">
              <?php if ($paged > 1): ?>
                <div class="prev">
                  <?php previous_posts_link('前へ'); ?>
                </div>
              <?php endif; ?>
              <div class="pages"><?php echo $paged; ?>/<?php echo $total_pages; ?></div>
              <ul class="queryy-pagination__pages">
                <?php
                $i = 1;
                foreach ($navs as $nav): ?>
                  <li class="page <?php echo $paged === $i
                    ? 'current'
                    : ''; ?>">
                    <?php echo $nav; ?>
                  </li>
                <?php $i++;endforeach;
                ?>
              </ul>
              <?php if ($paged < $total_pages): ?>
                <div class="next">
                  <?php next_posts_link('次へ', $total_pages); ?>
                </div>
              <?php endif; ?>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="writers-latest-entries-wrapper">
    <?php get_template_part('components/section', 'latest'); ?>
  </div>

  <div class="writers-ranking-entries-wrapper">
    <?php get_template_part('components/section', 'ranking'); ?>
  </div>

  <?php get_template_part('components/section', 'update'); ?>

  <div class="recommend-section-wrapper">
    <?php get_template_part('components/section', 'recommend'); ?>
  </div>
</main>

<?php get_footer();
