<?php
$args = wp_parse_args($args, [
  'categoryObject' => null,
  'tagsArray' => null,
]);

$bannerInfoArray = [
  'pc_image' => null,
  'sp_image' => null,
  'link_url' => null,
];

// PC画像が設定されているか（表示の最低条件の一部）
$hasPcImage = function ($popupBanner) {
  return !empty($popupBanner['pc_image']);
};

// バナーの遷移先URLが設定されているか（ACF「URL」or「リンク」両対応）
$hasLinkUrl = function ($popupBanner) {
  if (empty($popupBanner['link_url'])) return;

  if (is_array($popupBanner['link_url'])) {
    return !empty($popupBanner['link_url']['url']);
  }
  return !empty($popupBanner['link_url']);
};

// 表示条件の判定: PC画像 + リンクURL（SP画像は任意）
$isEligibleBanner = function ($popupBanner) use ($hasPcImage, $hasLinkUrl) {
  return $hasPcImage($popupBanner) && $hasLinkUrl($popupBanner);
};

// 共通設定（options）からバナー情報を取得し、画像+URLがあれば最優先で採用する
$popupBannerfromSettings = get_field('popup_banner', 'option');

$popupBannerFromCategoryArray = [];
$popupBannersFromTagArray = [];

if (!empty($popupBannerfromSettings) && $isEligibleBanner($popupBannerfromSettings)) {
  $bannerInfoArray = [
    'pc_image' => $popupBannerfromSettings['pc_image'] ?? null,
    'sp_image' => $popupBannerfromSettings['sp_image'] ?? null,
    'link_url' => $popupBannerfromSettings['link_url'] ?? null,
  ];
} else {
  // [共通設定に情報が登録されていない場合]
  // カテゴリー（ターム）からバナー情報を取得し、候補として保持する
  if ($args['categoryObject']) {
    $tempArray = get_field('popup_banner', $args['categoryObject']);
    if (!empty($tempArray) && $isEligibleBanner($tempArray)) {
      $popupBannerFromCategoryArray = $tempArray;
    }
  }

  // タグ（ターム）からバナー情報を取得し、候補化→優先順位でソートする
  if (!empty($args['tagsArray'])) {
    foreach ($args['tagsArray'] as $tag) {
      $popupBanner = get_field('popup_banner', $tag);
      if (!empty($popupBanner) && $isEligibleBanner($popupBanner)) {
        $popupBannersFromTagArray[] = $popupBanner;
      }
    }

    if (!empty($popupBannersFromTagArray)) {
      // 優先順位が昇順になるようにソート
      usort($popupBannersFromTagArray, function ($a, $b) {
        $priorityA = is_numeric($a['popup_banner_select']['label'])
          ? $a['popup_banner_select']['label']
          : PHP_INT_MAX;
        $priorityB = is_numeric($b['popup_banner_select']['label'])
          ? $b['popup_banner_select']['label']
          : PHP_INT_MAX;

        return $priorityA - $priorityB;
      });
    }
  }

  if (
    !empty($popupBannerFromCategoryArray) ||
    !empty($popupBannersFromTagArray)
  ) {
    // タグ由来のバナーがあれば優先的に表示させる。なければカテゴリーから
    $selectedBanner = !empty($popupBannersFromTagArray)
      ? $popupBannersFromTagArray[0]
      : $popupBannerFromCategoryArray;

    $bannerInfoArray = [
      'pc_image' => $selectedBanner['pc_image'] ?? null,
      'sp_image' => $selectedBanner['sp_image'] ?? null,
      'link_url' => $selectedBanner['link_url'] ?? null,
    ];
  }
}

$getImageId = function ($imageValue) {
  if (is_numeric($imageValue)) {
    return $imageValue;
  }
  if (!is_array($imageValue)) {
    return null;
  }
  return $imageValue['ID'] ?? $imageValue['id'] ?? null;
};

$pcImage = $bannerInfoArray['pc_image'];
$spImage = $bannerInfoArray['sp_image'];

// 表示の最低条件はpc_image必須（sp_imageのみのフォールバックはしない）

$pcImageId = $getImageId($pcImage);
$spImageId = $getImageId($spImage);

$linkUrl = '';
if (!empty($bannerInfoArray['link_url'])) {
  if (is_array($bannerInfoArray['link_url'])) {
    $linkUrl = $bannerInfoArray['link_url']['url'] ?? '';
  } else {
    $linkUrl = $bannerInfoArray['link_url'];
  }
}

$getAttachmentAlt = function ($attachmentId) {
  $alt = get_post_meta((int) $attachmentId, '_wp_attachment_image_alt', true);
  return is_string($alt) ? $alt : '';
};

$pcAlt = is_array($pcImage) ? ($pcImage['alt'] ?? '') : '';
if (empty($pcAlt) && !empty($pcImageId)) {
  $pcAlt = $getAttachmentAlt($pcImageId);
}

$spAlt = is_array($spImage) ? ($spImage['alt'] ?? '') : '';
if (empty($spAlt) && !empty($spImageId)) {
  $spAlt = $getAttachmentAlt($spImageId);
}
?>

<?php if (!empty($linkUrl) && !empty($pcImageId)): ?>
  <div class="popup-banner js-popup-banner<?php echo !empty($spImageId) ? ' has-sp-image' : ''; ?>">
    <a class="popup-banner__link" href="<?php echo esc_url($linkUrl); ?>">
      <div class="popup-banner__image pc">
        <?php
        $pcImageAttrs = [
          'class' => 'popup-banner__img',
          'loading' => 'lazy',
        ];
        if (!empty($pcAlt)) {
          $pcImageAttrs['alt'] = $pcAlt;
        }
        echo wp_get_attachment_image($pcImageId, 'full', false, $pcImageAttrs);
        ?>
      </div>

      <?php if (!empty($spImageId)): ?>
        <div class="popup-banner__image sp">
          <?php
          $spImageAttrs = [
            'class' => 'popup-banner__img',
            'loading' => 'lazy',
          ];
          if (!empty($spAlt)) {
            $spImageAttrs['alt'] = $spAlt;
          }
          echo wp_get_attachment_image($spImageId, 'full', false, $spImageAttrs);
          ?>
        </div>
      <?php endif; ?>
    </a>

    <button class="popup-banner__close js-popup-banner-closure" type="button">
      <svg width="16" height="15" viewBox="0 0 16 15" fill="none">
        <path d="M4.46436 3.53552L11.5354 10.6066" stroke="white"/>
        <path d="M11.5356 3.53552L4.46458 10.6066" stroke="white"/>
      </svg>
    </button>
  </div>
<?php endif; ?>
