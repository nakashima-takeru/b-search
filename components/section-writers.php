<?php
$counter = 0;
$args = wp_parse_args($args, [
  'userID' => null,
]);

$userArgs = [
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

$userQuery = new WP_User_Query($userArgs);
$users = $userQuery->get_results();

// 記事があるユーザーのみをフィルタリング
$usersWithPosts = [];
foreach ($users as $user) {
  $postCount = count_user_posts($user->ID, 'post', true);
  if ($postCount > 0) {
    $usersWithPosts[] = $user;
  }
}
?>

<?php if (!empty($usersWithPosts) && count($usersWithPosts) > 0): ?>
<div class="author-writer-slider-wrapper">
  <section class="queryy-basic-slider splide js-queryy-writer-slider">
    <div class="mainContainer queryy-basic-slider__wrapper stack60">
      <div class="border-overflow-area queryy-basic-slider__header">
        <header class="section-titleArea-2">
          <p class="section-titleArea-2__title">Writer</p>
          <h2 class="section-titleArea-2__subtitle">著者/監修者</h2>
        </header>
        <div class="splide__arrows queryy-basic-slider__btns">
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
      </div>
      <div class="queryy-basic-slider__inner">
        <div class="splide__track">
          <ul class="splide__list">
            <?php foreach ($usersWithPosts as $user):
              $user_position = get_field('user_position', $user); ?>
              <li class="splide__slide card-basic-slider">
                <div class="writer-item">
                  <a href="<?php echo esc_url(home_url('/writers') . '/' . $user->user_nicename); ?>" class="writer-item__link">
                    <div class="writer-item__thumbnail">
                      <?php echo get_avatar(
                        $user->ID,
                        96,
                        '',
                        $user->display_name,
                        ['loading' => 'lazy']
                      ); ?>
                    </div>
                    <h2 class="writer-item__name"><?php echo esc_html(
                      $user->display_name
                    ); ?></h2>
                    <?php if ($user_position): ?>
                      <p class="writer-item__position"><?php echo get_field(
                        'user_position',
                        $user
                      ); ?></p>
                    <?php endif; ?>
                  </a>
                </div>
              </li>
            <?php $counter++;
            endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
</div>
<?php endif; ?>
