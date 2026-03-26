<?php
// slug生成（例 topページの場合は home）
$pageSlug = '';
if (is_front_page() || is_home()) {
  $pageSlug = 'home';
} elseif (is_page()) {
  $pageSlug = get_post(get_the_ID())->post_name;
} elseif (is_author()) {
  $pageSlug = 'author';
} elseif (is_date()) {
  $pageSlug = 'date';
} elseif (is_archive() || is_single()) {
  $post_type = get_post_type();
  $pageSlug = $post_type ? get_post_type_object($post_type)->name : '';
}

// メディア用の読み込み
$current_url = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-TTQDPWM');
    </script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="icon" href="<?php echo esc_url(
      home_url()
    ); ?>/favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?php echo esc_url(
      home_url()
    ); ?>/apple-touch-icon.png">
    <meta name="thumbnail" content="<?php echo esc_url(
      home_url()
    ); ?>/thumbnail.png">
    <!-- font share -->
    <link rel='stylesheet prefetch' href='//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>

    <link href="https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@800&f[]=satoshi@700,500,400&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body data-page="<?php echo $pageSlug; ?>" <?php body_class(); ?> data-device="">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTQDPWM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

    <?php if (!is_singular('post')): ?>
      <?php include 'components/header-cta.php'; ?>
    <?php endif; ?>
    <span class="global-header-transition-observer-line js-global-header-transition-observer-line"></span>
    <div class="global-header__overlay js-global-header-overlay"></div>
    <!-- header -->
    <?php include 'components/header-menu.php'; ?>
    <!-- End.header -->

  <!-- modal -->
  <?php include 'components/modal-search.php'; ?>
  <!-- End.modal -->
