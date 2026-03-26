<?php
$args = wp_parse_args($args, [
  'categoryObject' => null,
  'tagsArray' => null,
]);

$bannerInfoArray = [
  'image' => null,
  'url' => null,
];

// 共通設定に設定されているバナー情報
$interstitialBannerfromSettings = get_field('interstitial_banner', 'option') ?: [];

$interstitialBannerFromCategoryArray = [];
$interstitialBannersFromTagArray = [];

if (
  !empty($interstitialBannerfromSettings['interstitial_banner_image']) &&
  !empty($interstitialBannerfromSettings['interstitial_banner_url'])
) {
  $bannerInfoArray = [
    'image' =>
      $interstitialBannerfromSettings['interstitial_banner_image']['url'],
    'url' => $interstitialBannerfromSettings['interstitial_banner_url']['url'],
  ];
} else {
  if ($args['categoryObject']) {
    $tempArray = get_field('interstitial_banner', $args['categoryObject']) ?: [];
    if (
      !empty($tempArray['interstitial_banner_image']) &&
      !empty($tempArray['interstitial_banner_url'])
    ) {
      $interstitialBannerFromCategoryArray = $tempArray;
    }
  }

  if (!empty($args['tagsArray'])) {
    // 画像とURL両方を持つものに絞り込む
    foreach ($args['tagsArray'] as $tag) {
      $interstitialBanner = get_field('interstitial_banner', $tag) ?: [];
      if (
        !empty($interstitialBanner['interstitial_banner_image']) ||
        !empty($interstitialBanner['interstitial_banner_url'])
      ) {
        $interstitialBannersFromTagArray[] = $interstitialBanner;
      }
    }

    if (!empty($interstitialBannersFromTagArray)) {
      // 優先順位が昇順になるようにソート
      usort($interstitialBannersFromTagArray, function ($a, $b) {
        $priorityA = is_numeric($a['interstitial_banner_select']['label'])
          ? $a['interstitial_banner_select']['label']
          : PHP_INT_MAX;
        $priorityB = is_numeric($b['interstitial_banner_select']['label'])
          ? $b['interstitial_banner_select']['label']
          : PHP_INT_MAX;

        return $priorityA - $priorityB;
      });
    }
  }

  if (
    !empty($interstitialBannerFromCategoryArray) ||
    !empty($interstitialBannersFromTagArray)
  ) {
    // タグ由来のバナーがあれば優先的に表示させる。なければカテゴリーから
    if (!empty($interstitialBannersFromTagArray)) {
      $bannerInfoArray = [
        'image' =>
          $interstitialBannersFromTagArray[0]['interstitial_banner_image'][
            'url'
          ],
        'url' =>
          $interstitialBannersFromTagArray[0]['interstitial_banner_url']['url'],
      ];
    } else {
      $bannerInfoArray = [
        'image' =>
          $interstitialBannerFromCategoryArray['interstitial_banner_image'][
            'url'
          ],
        'url' =>
          $interstitialBannerFromCategoryArray['interstitial_banner_url'][
            'url'
          ],
      ];
    }
  }
}
?>


<?php if ($bannerInfoArray['image'] && $bannerInfoArray['url']): ?>
  <div class="interstitial-banner js-interstitial-banner">
    <div class="interstitial-banner__sp-closure js-interstitial-banner-closure"></div>
    <div class="interstitial-banner__wrapper">
      <div class="interstitial-banner__inner">
        <a href="<?php echo esc_url(
          $bannerInfoArray['url']
        ); ?>" class="interstitial-banner__link">
          <img src="<?php echo esc_attr(
            $bannerInfoArray['image']
          ); ?>" alt="" class="interstitial-banner__image">
        </a>
        <button class="interstitial-banner__closure js-interstitial-banner-closure">
          <svg width="30" height="29" viewBox="0 0 30 29" fill="none">
            <path d="M7.92871 7.07106L22.0708 21.2132" stroke="white"/>
            <path d="M22.0713 7.07106L7.92915 21.2132" stroke="white"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
<?php endif; ?>
