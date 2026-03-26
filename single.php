<?php
get_header();

$postID = get_queried_object_id();
$catArray = get_the_category($postID);
$cat = $catArray[0] ?? null;
$tags = get_the_tags($postID) ?: [];
$taxSlug = 'category';
$termId = $cat->cat_ID ?? null;
$termName = $cat->cat_name ?? '';
$cta = $cat ? get_field('cta', $cat) : null;

$categoryDownloadBanner = null;
$tagDownloadBanner = null;
$downloadBannerInfo = null;
$downloadBannerInfoJson = null;

// ダウンロードバナー情報 from カテゴリー設定
$tempCategoryBannerArray = $cat ? get_field('download_banner', $cat) : null;
if (
  !empty($tempCategoryBannerArray['download_banner_title']) &&
  !empty($tempCategoryBannerArray['download_banner_value']) &&
  !empty($tempCategoryBannerArray['download_banner_form_id'])
) {
  $categoryDownloadBanner = $tempCategoryBannerArray;
}

// ダウンロードバナー情報 from タグ設定
$downloadBannerFromTagArray = [];

if (!empty($tags)) {
  foreach ($tags as $tag) {
    $tempTagBannerArray = get_field('download_banner', $tag);
    if (
      !empty($tempTagBannerArray['download_banner_title']) &&
      !empty($tempTagBannerArray['download_banner_value']) &&
      !empty($tempTagBannerArray['download_banner_form_id'])
    ) {
      $downloadBannerFromTagArray[] = $tempTagBannerArray;
    }
  }

  if (!empty($downloadBannerFromTagArray)) {
    usort($downloadBannerFromTagArray, function ($a, $b) {
      $priorityA = is_numeric($a['download_banner_select']['label'])
        ? $a['download_banner_select']['label']
        : PHP_INT_MAX;
      $priorityB = is_numeric($b['download_banner_select']['label'])
        ? $b['download_banner_select']['label']
        : PHP_INT_MAX;

      return $priorityA - $priorityB;
    });
  }
}
$tagDownloadBanner = !empty($downloadBannerFromTagArray)
  ? $downloadBannerFromTagArray[0]
  : null;

$downloadBanner = $tagDownloadBanner
  ? $tagDownloadBanner
  : $categoryDownloadBanner;
if ($downloadBanner) {
  $downloadBannerInfo = [
    $downloadBanner['download_banner_value'],
    $downloadBanner['download_banner_form_id'],
  ];

  $downloadBannerInfoJson = json_encode($downloadBannerInfo);
}

$authorID = get_the_author_meta('ID');
$authorSlug = get_the_author_meta('nicename');
$writerID = get_field('writerUserId');

$related_services_links = get_post_meta(get_the_ID(), 'related_services_links', true);
?>

<script>
  var downloadBannerInfo = JSON.parse('<?php echo $downloadBannerInfoJson; ?>');
</script>

<main class="queryy-main queryy-lower-page">
  <div class="stack15">
    <div class="queryy-breadcrumb">
      <div class="breadcrumbs-area">
        <?php //この部分のみ、パンクズ構造化のルールが異なるため、YoastSEOのカスタマイズを出力しております。

        if (function_exists('yoast_breadcrumb')) {
          yoast_breadcrumb('<div class="breadcrumbs-area__list">', '</div>');
        } ?>
      </div>
    </div>
    <div class="mainContainer">
      <div class="queryy-single-sidebar">
        <div class="stack30">
          <?php if (have_posts()):
            while (have_posts()):

              the_post();
              $title = get_the_title();
              $url = get_permalink();
          ?>
              <article class="queryy-entry js-queryy-entry">
                <header class="queryy-entry__header">
                  <div class="queryy-entry__meta">
                    <div class="queryy-entry__cluster">
                      <div class="label-category-small"><?php echo esc_html($cat->name); ?></div>
                      <div class="queryy-entry__date">
                        <span>最終更新日：</span>
                        <span><?php the_modified_date('Y.m.d'); ?></span>
                      </div>
                    </div>
                    <div class="queryy-entry__cluster entry-top-sns">
                      <div>
                        <a
                          href="https://twitter.com/share?url=<?php echo $url; ?>&text=<?php echo urlencode($title); ?>"
                          target="_blank"
                          rel="noopener noreferrer"
                          class="entry-top-sns__icon">
                          <svg width="22" height="18" viewBox="0 0 22 18" fill="none" class="twitter">
                            <path d="M6.91795 18C15.2195 18 19.7551 11.0773 19.7551 5.06841C19.7551 4.87458 19.7551 4.67151 19.7459 4.47768C20.6256 3.83156 21.3953 3.03776 22 2.12396C21.1753 2.49317 20.3049 2.73316 19.4069 2.83469C20.3507 2.26242 21.0562 1.37631 21.3861 0.324064C20.4973 0.850189 19.5352 1.22863 18.5181 1.43169C16.8138 -0.395895 13.955 -0.488198 12.1316 1.23786C10.9588 2.34549 10.464 3.99771 10.8305 5.57608C7.202 5.39147 3.82091 3.66542 1.5302 0.831728C0.329863 2.90854 0.943773 5.56685 2.92295 6.89601C2.20825 6.87754 1.50271 6.68371 0.879633 6.33296V6.38834C0.879633 8.54822 2.3915 10.4127 4.49896 10.8466C3.83923 11.0312 3.13369 11.0588 2.46481 10.9204C3.06039 12.7757 4.74636 14.0402 6.67972 14.0771C5.08538 15.3417 3.10621 16.0247 1.07205 16.0247C0.714702 16.0247 0.357351 16.0063 0 15.9601C2.06164 17.2893 4.46231 18 6.91795 18Z" fill="#1DA1F2" />
                          </svg>
                        </a>
                      </div>
                      <div>
                        <a
                          href="https://www.facebook.com/share.php?u=<?php echo $url; ?>&t=<?php echo urlencode($title); ?>"
                          target="_blank"
                          rel="noopener noreferrer">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="fb">
                            <path d="M23 12.0645C23 5.95138 18.0775 1 12 1C5.9225 1 1 5.95138 1 12.0645C1 17.5876 5.02417 22.1609 10.2767 22.9908V15.2548H7.49V12.0645H10.2858V9.63034C10.2858 6.85499 11.9267 5.32439 14.4383 5.32439C15.6392 5.32439 16.9042 5.53646 16.9042 5.53646V8.2565H15.52C14.1542 8.2565 13.7233 9.114 13.7233 9.98072V12.0645H16.7758L16.29 15.264H13.7233V23C18.9758 22.1609 23 17.5876 23 12.0645Z" fill="#1877F2" />
                          </svg>
                        </a>
                      </div>
                      <div>
                        <a
                          href="https://b.hatena.ne.jp/add?mode=confirm&url=<?php $url; ?>"
                          target="_blank"
                          rel="noopener noreferrer">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hatena">
                            <path d="M18.5186 1H5.4814C3.00639 1 1 3.00639 1 5.4814V18.5186C1 20.9936 3.00639 23 5.4814 23H18.5186C20.9936 23 23 20.9936 23 18.5186V5.4814C23 3.00639 20.9936 1 18.5186 1Z" fill="#00A4DE" />
                            <path d="M13.2403 12.3564C12.8417 11.9112 12.2877 11.6608 11.5771 11.6067C12.2094 11.4342 12.6687 11.1821 12.9591 10.8455C13.2482 10.5133 13.3917 10.0618 13.3917 9.49424C13.3917 9.04456 13.2935 8.64724 13.103 8.3036C12.9077 7.96216 12.6274 7.68892 12.2587 7.48432C11.9361 7.307 11.5529 7.18204 11.1059 7.10812C10.6566 7.03684 9.87078 7.00032 8.74306 7.00032H6.00098V17.0002H8.82622C9.96098 17.0002 10.7794 16.9606 11.2801 16.8845C11.7799 16.8057 12.1997 16.6737 12.5389 16.4924C12.9587 16.2707 13.2795 15.9552 13.503 15.55C13.7283 15.1434 13.84 14.6748 13.84 14.1384C13.84 13.397 13.6403 12.8008 13.2403 12.3569V12.3564ZM8.53274 9.21704H9.11794C9.79422 9.21704 10.2487 9.2936 10.4833 9.4454C10.7147 9.59808 10.8326 9.86208 10.8326 10.2374C10.8326 10.6127 10.7072 10.8534 10.4586 11.0026C10.2069 11.1491 9.74802 11.2234 9.07658 11.2234H8.5323V9.21704H8.53274ZM10.8542 14.9516C10.588 15.1152 10.1291 15.1953 9.48534 15.1953H8.53274V13.0107H9.52626C10.1876 13.0107 10.6447 13.0939 10.8876 13.2602C11.1345 13.4265 11.2563 13.72 11.2563 14.1415C11.2563 14.5186 11.123 14.7892 10.8542 14.952V14.9516Z" fill="white" />
                            <path d="M16.7331 14.4666C16.033 14.4666 15.4663 15.0334 15.4663 15.733C15.4663 16.4326 16.0335 16.9997 16.7331 16.9997C17.4327 16.9997 17.9994 16.4326 17.9994 15.733C17.9994 15.0334 17.4318 14.4666 16.7331 14.4666Z" fill="white" />
                            <path d="M17.8338 6.99985H15.6338V13.6667H17.8338V6.99985Z" fill="white" />
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <h1 class="queryy-entry__title"><?php the_title(); ?></h1>
                  <?php if ($tags): ?>
                    <div class="queryy-entry__tags">
                      <ul class="queryy-entry__cluster">
                        <?php foreach ($tags as $tag): ?>
                          <li class="tagItem">
                            <a href="<?php echo home_url('/tag'); ?>/<?php echo $tag->slug; ?>" class="tagItem__wrapper">
                              <div class="tagItem__icon">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                  <mask id="mask0_84_4772" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="14" height="14">
                                    <rect width="14" height="14" fill="#D9D9D9" />
                                  </mask>
                                  <g mask="url(#mask0_84_4772)">
                                    <path d="M8.31087 13.4834C8.08726 13.707 7.81018 13.8188 7.47962 13.8188C7.14907 13.8188 6.87198 13.707 6.64837 13.4834L1.51504 8.35003C1.40809 8.24308 1.32303 8.1167 1.25983 7.97086C1.19664 7.82503 1.16504 7.66947 1.16504 7.5042V3.33336C1.16504 3.01253 1.27928 2.73788 1.50775 2.5094C1.73622 2.28093 2.01087 2.1667 2.33171 2.1667H6.50254C6.66782 2.1667 6.82337 2.19829 6.9692 2.26149C7.11504 2.32468 7.24143 2.40975 7.34837 2.5167L12.4817 7.66461C12.7053 7.88822 12.8171 8.16288 12.8171 8.48857C12.8171 8.81427 12.7053 9.08892 12.4817 9.31253L8.31087 13.4834ZM3.79004 5.6667C4.03309 5.6667 4.23969 5.58163 4.40983 5.41149C4.57997 5.24135 4.66504 5.03475 4.66504 4.7917C4.66504 4.54864 4.57997 4.34204 4.40983 4.1719C4.23969 4.00177 4.03309 3.9167 3.79004 3.9167C3.54698 3.9167 3.34039 4.00177 3.17025 4.1719C3.00011 4.34204 2.91504 4.54864 2.91504 4.7917C2.91504 5.03475 3.00011 5.24135 3.17025 5.41149C3.34039 5.58163 3.54698 5.6667 3.79004 5.6667Z" fill="#808080" />
                                  </g>
                                </svg>
                              </div>
                              <p class="tagItem__text text-line"><?php echo $tag->name; ?></p>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                </header>
                <?php if (has_post_thumbnail($post->ID)) { ?>
                  <div>
                    <?php echo get_the_post_thumbnail($post->ID, 'full'); ?>
                  </div>
                <?php } ?>
                <div class="entry-content">
                  <?php
                  $authorID = get_the_author_meta('ID');
                  $writerID = get_field('writerUserId');
                  ?>
                  <div class="authors-box">
                    <?php if (
                      $authorID ||
                      (!$writerID || $writerID !== $authorID)
                    ): ?>
                      <div class="entry-author-media js-author">
                        <div class="entry-author-media__img">
                          <?php echo get_avatar($authorID); ?>
                        </div>
                        <div class="entry-author-media__text">
                          <div class="entry-author-media__header">
                            <p class="entry-author-media__label">監修者</p>
                            <p class="entry-author-media__name">
                              <span><?php echo get_the_author_meta(
                                      'display_name'
                                    ); ?></span>
                            </p>
                          </div>
                          <div class="entry-author-media__desc js-author__desc">
                            <?php echo wpautop(
                              get_the_author_meta('description')
                            ); ?>
                          </div>
                          <div class="entry-author-media__more js-author__more">...続きを読む</div>
                        </div>
                      </div>
                    <?php endif; ?>
                    <?php if ($writerID): ?>
                      <div class="entry-author-media js-author">
                        <div class="entry-author-media__img">
                          <?php echo get_avatar($writerID); ?>
                        </div>
                        <div class="entry-author-media__text">
                          <div class="entry-author-media__header">
                            <p class="entry-author-media__label">執筆者</p>
                            <p class="entry-author-media__name">
                              <span><?php echo get_field(
                                      'company',
                                      'user_' . $writerID
                                    ); ?></span>
                              <span><?php echo get_field(
                                      'display_name',
                                      'user_' . $writerID
                                    ); ?></span>
                            </p>
                          </div>
                          <div class="entry-author-media__desc js-author__desc">
                            <?php echo wpautop(
                              get_field('description', 'user_' . $writerID)
                            ); ?>
                          </div>
                          <div class="entry-author-media__more js-author__more">...続きを読む</div>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                  <?php

                  $pointTitle = get_field('pointTitle');
                  $pointLead = get_field('pointLead');

                  if ($pointTitle && have_rows('pointList')): ?>
                    <div class="pointBox">
                      <p class="pointTitle"><?php echo esc_html($pointTitle); ?></p>
                      <div class="pointInner">
                        <?php if ($pointLead): ?>
                          <div class="pointLead"><?php echo $pointLead; ?></div>
                        <?php endif; ?>
                        <dl class="pointBox__list">
                          <?php while (have_rows('pointList')): the_row(); ?>
                            <dt>
                              <?php the_sub_field('point'); ?>
                            </dt>
                            <dd>
                              <?php the_sub_field('explain'); ?>
                            </dd>
                          <?php endwhile; ?>
                        </dl>
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php
                  the_content();

                  $faqTitle = get_field('faqTitle');

                  if ($faqTitle && have_rows('faqList')): ?>
                    <div itemscope="" itemtype="https://schema.org/FAQPage" class="faqBox">
                      <h2><?php echo esc_html(
                            $faqTitle
                          ); ?>のよくあるご質問</h2>
                      <dl class="faqBox__list">
                        <?php while (have_rows('faqList')):
                          the_row(); ?>
                          <div itemscope="" itemprop="mainEntity" itemtype="https://schema.org/Question" class="faqItem">
                            <dt itemprop="name" class="faqItem__q"><?php the_sub_field(
                                                                      'q'
                                                                    ); ?></dt>
                            <dd itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" class="faqItem__a">
                              <p itemprop="text"><?php the_sub_field(
                                                    'a'
                                                  ); ?></p>
                            </dd>
                          </div>
                        <?php
                        endwhile; ?>
                      </dl>
                    </div>
                  <?php endif;
                  ?>
                </div>
              </article>
          <?php
            endwhile;
          endif; ?>
          <div class="entry-banner-links">
            <a href="<?php echo home_url(
                        '/download-pdf'
                      ); ?>" class="entry-banner-link-item download">
              <div class="entry-banner-link-item__text">
                <p class="entry-banner-link-item__en">Download</p>
                <p class="entry-banner-link-item__jp">お役立ち資料ダウンロード</p>
              </div>
              <div class="entry-banner-link-item__icon">
                <svg width="14" height="13" viewBox="0 0 14 13" fill="none">
                  <path d="M1 3.23047V11.5382H13V3.23047" stroke="white" />
                  <path d="M7 0V7.38462" stroke="white" />
                  <path d="M4.69238 5.07715L7.00008 7.84638L9.30777 5.07715" stroke="white" />
                </svg>
              </div>
            </a>
            <a href="<?php echo home_url(
                        '/contact'
                      ); ?>" class="entry-banner-link-item contact">
              <div class="entry-banner-link-item__text">
                <p class="entry-banner-link-item__en">Contact</p>
                <p class="entry-banner-link-item__jp">Web制作に関する無料相談はこちら</p>
              </div>
              <div class="entry-banner-link-item__icon">
                <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                  <path d="M0.799902 0.799805L6.3999 3.9998L0.799902 7.1998" stroke="white" />
                </svg>
              </div>
            </a>
          </div>
          <div class="entry-bottom-sns">
            <div>
              <a
                href="https://twitter.com/share?url=<?php echo $url; ?>&text=<?php echo urlencode(
                                                                                $title
                                                                              ); ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="entry-bottom-sns__link twitter">
                <svg width="22" height="18" viewBox="0 0 22 18" fill="none">
                  <path d="M6.91795 18C15.2195 18 19.7551 11.0773 19.7551 5.06841C19.7551 4.87458 19.7551 4.67151 19.7459 4.47768C20.6256 3.83156 21.3953 3.03776 22 2.12396C21.1753 2.49317 20.3049 2.73316 19.4069 2.83469C20.3507 2.26242 21.0562 1.37631 21.3861 0.324064C20.4973 0.850189 19.5352 1.22863 18.5181 1.43169C16.8138 -0.395895 13.955 -0.488198 12.1316 1.23786C10.9588 2.34549 10.464 3.99771 10.8305 5.57608C7.202 5.39147 3.82091 3.66542 1.5302 0.831728C0.329863 2.90854 0.943773 5.56685 2.92295 6.89601C2.20825 6.87754 1.50271 6.68371 0.879633 6.33296V6.38834C0.879633 8.54822 2.3915 10.4127 4.49896 10.8466C3.83923 11.0312 3.13369 11.0588 2.46481 10.9204C3.06039 12.7757 4.74636 14.0402 6.67972 14.0771C5.08538 15.3417 3.10621 16.0247 1.07205 16.0247C0.714702 16.0247 0.357351 16.0063 0 15.9601C2.06164 17.2893 4.46231 18 6.91795 18Z" fill="#1DA1F2" />
                </svg>
              </a>
            </div>
            <div>
              <a
                href="https://www.facebook.com/share.php?u=<?php echo $url; ?>&t=<?php echo urlencode(
                                                                                    $title
                                                                                  ); ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="entry-bottom-sns__link fb">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M23 12.0645C23 5.95138 18.0775 1 12 1C5.9225 1 1 5.95138 1 12.0645C1 17.5876 5.02417 22.1609 10.2767 22.9908V15.2548H7.49V12.0645H10.2858V9.63034C10.2858 6.85499 11.9267 5.32439 14.4383 5.32439C15.6392 5.32439 16.9042 5.53646 16.9042 5.53646V8.2565H15.52C14.1542 8.2565 13.7233 9.114 13.7233 9.98072V12.0645H16.7758L16.29 15.264H13.7233V23C18.9758 22.1609 23 17.5876 23 12.0645Z" fill="#1877F2" />
                </svg>
              </a>
            </div>
            <div>
              <a
                href="https://b.hatena.ne.jp/add?mode=confirm&url=<?php $url; ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="entry-bottom-sns__link hatena">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M18.5186 1H5.4814C3.00639 1 1 3.00639 1 5.4814V18.5186C1 20.9936 3.00639 23 5.4814 23H18.5186C20.9936 23 23 20.9936 23 18.5186V5.4814C23 3.00639 20.9936 1 18.5186 1Z" fill="#00A4DE" />
                  <path d="M13.2403 12.3564C12.8417 11.9112 12.2877 11.6608 11.5771 11.6067C12.2094 11.4342 12.6687 11.1821 12.9591 10.8455C13.2482 10.5133 13.3917 10.0618 13.3917 9.49424C13.3917 9.04456 13.2935 8.64724 13.103 8.3036C12.9077 7.96216 12.6274 7.68892 12.2587 7.48432C11.9361 7.307 11.5529 7.18204 11.1059 7.10812C10.6566 7.03684 9.87078 7.00032 8.74306 7.00032H6.00098V17.0002H8.82622C9.96098 17.0002 10.7794 16.9606 11.2801 16.8845C11.7799 16.8057 12.1997 16.6737 12.5389 16.4924C12.9587 16.2707 13.2795 15.9552 13.503 15.55C13.7283 15.1434 13.84 14.6748 13.84 14.1384C13.84 13.397 13.6403 12.8008 13.2403 12.3569V12.3564ZM8.53274 9.21704H9.11794C9.79422 9.21704 10.2487 9.2936 10.4833 9.4454C10.7147 9.59808 10.8326 9.86208 10.8326 10.2374C10.8326 10.6127 10.7072 10.8534 10.4586 11.0026C10.2069 11.1491 9.74802 11.2234 9.07658 11.2234H8.5323V9.21704H8.53274ZM10.8542 14.9516C10.588 15.1152 10.1291 15.1953 9.48534 15.1953H8.53274V13.0107H9.52626C10.1876 13.0107 10.6447 13.0939 10.8876 13.2602C11.1345 13.4265 11.2563 13.72 11.2563 14.1415C11.2563 14.5186 11.123 14.7892 10.8542 14.952V14.9516Z" fill="white" />
                  <path d="M16.7331 14.4666C16.033 14.4666 15.4663 15.0334 15.4663 15.733C15.4663 16.4326 16.0335 16.9997 16.7331 16.9997C17.4327 16.9997 17.9994 16.4326 17.9994 15.733C17.9994 15.0334 17.4318 14.4666 16.7331 14.4666Z" fill="white" />
                  <path d="M17.8338 6.99985H15.6338V13.6667H17.8338V6.99985Z" fill="white" />
                </svg>
              </a>
            </div>
          </div>
          <section class="supervisor-introduction">
            <header class="supervisor-introduction__header">
              <div class="supervisor-introduction__img">
                <?php echo get_avatar($authorID); ?>
              </div>
              <div>
                <p class="supervisor-introduction__label">監修者紹介</p>
                <h2 class="supervisor-introduction__name">
                  <a href="<?php echo esc_url(home_url('/writers') . '/' . $authorSlug); ?>">
                    <?php echo get_the_author_meta('display_name'); ?>
                  </a>
                </h2>
                <p class="supervisor-introduction__position">
                  <?php echo get_field(
                    'user_position',
                    'user_' . $authorID
                  ); ?></p>
              </div>
            </header>
            <div class="supervisor-introduction__description">
              <?php echo wpautop(get_the_author_meta('description')); ?>
            </div>
          </section>
          <?php
          $previousEntry = get_adjacent_post(true, '', true);
          $nextEntry = get_adjacent_post(true, '', false);

          if ($previousEntry || $nextEntry): ?>
            <div class="single-relation-entries">
              <div>
                <?php
                  if ($previousEntry):
                  $categories = get_the_category($previousEntry->ID);
                ?>
                  <a href="<?php echo get_permalink(
                              $previousEntry->ID
                            ); ?>" class="single-relation-entry prev stack10">
                    <article class="single-relation-entry__inner">
                      <div class="single-relation-entry__img">
                        <?php echo get_the_post_thumbnail(
                          $previousEntry->ID,
                          'medium_large',
                          ['loading' => 'lazy']
                        ); ?>
                      </div>
                      <div class="single-relation-entry__text">
                        <time class="single-relation-entry__date"><?php echo get_the_modified_date(
                                                                    'Y.m.d',
                                                                    $previousEntry->ID
                                                                  ); ?></time>
                        <h2 class="single-relation-entry__title"><?php echo get_the_title(
                                                                    $previousEntry->ID
                                                                  ); ?></h2>
                        <?php if ($categories): ?>
                          <div class="label-category-small single-relation-entry__category"><?php echo esc_html(
                                                                                              $categories[0]->name
                                                                                            ); ?></div>
                        <?php endif; ?>
                      </div>
                    </article>
                    <div class="single-relation-entry__button">
                      <button class="carousel-arrow-btn">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                          <path d="M7.2001 0.799805L1.6001 3.9998L7.2001 7.1998" stroke="white" />
                        </svg>
                      </button>
                      <span>前の記事</span>
                    </div>
                  </a>
                <?php
                endif; ?>
              </div>
              <div class="single-relation-entries__divider"></div>
              <div>
                <?php
                  if ($nextEntry):
                  $categories = get_the_category($nextEntry->ID);
                ?>
                  <a href="<?php echo get_permalink(
                              $nextEntry->ID
                            ); ?>" class="single-relation-entry next stack10">
                    <article class="single-relation-entry__inner">
                      <div class="single-relation-entry__img">
                        <?php echo get_the_post_thumbnail($nextEntry->ID); ?>
                      </div>
                      <div class="single-relation-entry__text">
                        <time class="single-relation-entry__date"><?php echo get_the_modified_date(
                                                                    'Y.m.d',
                                                                    $nextEntry->ID
                                                                  ); ?></time>
                        <h2 class="single-relation-entry__title"><?php echo get_the_title(
                                                                    $nextEntry->ID
                                                                  ); ?></h2>
                        <?php if ($categories): ?>
                          <div class="label-category-small single-relation-entry__category"><?php echo esc_html(
                                                                                              $categories[0]->name
                                                                                            ); ?></div>
                        <?php endif; ?>
                      </div>
                    </article>
                    <div class="single-relation-entry__button">
                      <span>次の記事</span>
                      <button class="carousel-arrow-btn">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                          <path d="M0.799902 0.799805L6.3999 3.9998L0.799902 7.1998" stroke="white" />
                        </svg>
                      </button>
                    </div>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif;
          ?>
        </div>
        <div>
          <div class="queryy-single-sidebar__sticky-box">
            <div class="queryy-single-sidebar__sticky-item">
	              <?php get_template_part(
	                'components/download-banner-form',
	                null,
	                [
	                  'downloadBanner' => $downloadBanner,
	                ]
	              ); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- download-pdf -->
  <?php
  $downloadItems = get_field('select_download-pdf', $cat);
  if ($downloadItems): ?>
    <section class="download-pickup">
      <div class="mainContainer">
        <header class="section-titleArea">
          <div class="section-titleArea__en">Download</div>
          <h2 class="section-titleArea__jp">お役立ち資料ダウンロード</h2>
        </header>
        <div class="download-pickup__list">
          <?php foreach ($downloadItems as $item): ?>
            <?php get_template_part('components/card', 'download', [
              'id' => $item->ID,
            ]); ?>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif;
  ?>

  <div class="queryy-single-slider-wrapper">
	    <?php get_template_part('components/section', 'relation', [
	      'post_id' => $postID,
	      'tags' => $tags,
	      'category' => $cat,
	    ]); ?>
  </div>

  <div class="queryy-single-slider-wrapper latest">
	    <?php get_template_part('components/section', 'latest', [
	      'color' => 'gray',
	    ]); ?>
  </div>

  <!-- Ranking-->
  <div class="queryy-single-slider-wrapper">
	    <?php get_template_part('components/section', 'ranking'); ?>
  </div>

  <div class="recommend-section-wrapper">
	    <?php get_template_part('components/section', 'recommend'); ?>
  </div>
	  <?php get_template_part('components/popup-banner', null, [
	    'categoryObject' => $cat,
	    'tagsArray' => $tags,
	  ]); ?>

	  <?php get_template_part('components/interstitial-banner', null, [
	    'categoryObject' => $cat,
	    'tagsArray' => $tags,
	  ]); ?>
</main>

<?php get_footer();
