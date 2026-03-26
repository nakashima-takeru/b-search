<?php
/**
 * メディア用: ブログ検索結果ページかどうかを判定する。
 * - 通常の検索（is_search）とは別に、/articles/search?search_type=blog のような固定ページ扱いのURLも対象にする
 */
function queryy_is_blog_search_page() {
  $type = isset($_GET['search_type'])
    ? sanitize_key(wp_unslash($_GET['search_type']))
    : '';

  if ($type !== 'blog') {
    return false;
  }

  // 標準の検索クエリとして解決されている場合
  if (is_search()) {
    return true;
  }

  // /articles/search など、固定ページとして解決される検索URLのフォールバック
  $requestUri = $_SERVER['REQUEST_URI'] ?? '';
  $path = $requestUri ? wp_parse_url($requestUri, PHP_URL_PATH) : '';
  if (!$path) {
    return false;
  }

  return strpos($path, '/articles/search') === 0;
}

require_once get_theme_file_path('./_admin/post-blog.php'); // 投稿タイプ「blog」

// 投稿タイプ
require_once get_theme_file_path('./_custom-posts/download-pdf.php');

/*--------------------------------------------------------------
style・scriptの読み込み
--------------------------------------------------------------*/
function my_enqueue_scripts() {
  // メディア用の読み込み
  $current_url = $_SERVER['REQUEST_URI'];

  // ページのスラッグを取得
  $pageSlug = '';
  if (is_front_page())
    $pageSlug = 'front-page';
  elseif (is_home()) {
    $pageSlug = 'home';
  } elseif (is_page()) {
    $pageSlug = get_post(get_the_ID())->post_name;
  } elseif (is_author()) {
    $pageSlug = 'author';
  } elseif (is_date()) {
    $pageSlug = 'date';
  } elseif (is_404()) {
    $pageSlug = '404';
  } elseif (is_archive() || is_single()) {
    $post_type = get_post_type();
    $pageSlug = $post_type ? get_post_type_object($post_type)->name : '';
  }

  $cssFileName =
    get_template_directory() . '/assets/css/pages/' . $pageSlug . '.css';
  $cssQuerryFileName =
    get_template_directory() . '/assets/css/queryy/pages/' . $pageSlug . '.css';
  $jsFileName =
    get_template_directory() . '/assets/js/pages/' . $pageSlug . '.js';

  // cssの読み込み
  $post_id = get_the_ID();
  $post_type = get_post_type($post_id);
  if (!is_admin()) {
    // 全ページ共通
    wp_enqueue_style(
      'common_css',
      get_template_directory_uri() . '/assets/css/common.css',
      [],
      false,
      ''
    );

    // 固定ページ共通
    wp_enqueue_style(
      'page_css',
      get_template_directory_uri() . '/assets/css/pages/page.css',
      [],
      false,
      ''
    );

    if (is_singular('download-pdf')) {
      wp_enqueue_style(
        'glide',
        get_template_directory_uri() .
          '/assets/css/lib/glide/glide.core.min.css',
        [],
        '1.0',
        ''
      );
      wp_enqueue_style(
        'glide_theme',
        get_template_directory_uri() .
          '/assets/css/lib/glide/glide.theme.min.css',
        [],
        '1.0',
        ''
      );
    }
    // $pageSlugと、slug名と一致したファイル名が存在していたらcss読み込みます。
    if (is_file($cssFileName)) {
      wp_enqueue_style(
        $pageSlug,
        get_template_directory_uri() .
          '/assets/css/pages/' .
          $pageSlug .
          '.css',
        [],
        false,
        ''
      );
    }

    // サンクスページテンプレート専用CSS（ページslugに依存せず読み込む）
    if (is_page_template('page-thanks.php')) {
      $thanksCssFileName =
        get_template_directory() . '/assets/css/pages/thanks.css';
      if (is_file($thanksCssFileName)) {
        wp_enqueue_style(
          'thanks_css',
          get_template_directory_uri() . '/assets/css/pages/thanks.css',
          [],
          false,
          ''
        );
      }
    }
  }
  // jsの読み込み
  if (!is_admin()) {
     // axios.js を全ページで読み込む
     wp_enqueue_script(
      'axios',
      get_template_directory_uri() . '/assets/js/lib/axios/axios.min.js',
      [],
      null,
      true
    );

    // GSAPを読み込む
    wp_enqueue_script(
      'gsap',
      get_template_directory_uri() . '/assets/js/lib/gsap/gsap.min.js',
      [],
      null,
      true
    );

    // 全ページ共通のapp.jsを読み込む（GSAPに依存）
    wp_enqueue_script(
      'app',
      get_template_directory_uri() . '/assets/js/app.js',
      ['gsap'],
      null,
      true
    );

    // Splide（必要ページのみ）
    if (
      is_front_page() ||
      is_home() ||
      is_page('blog') ||
      is_page('articles') ||
      is_page('writers') ||
      is_author() ||
      is_search() ||
      queryy_is_blog_search_page() ||
      is_archive() ||
      is_singular('post')
    ) {
      wp_enqueue_script(
        'splide',
        get_template_directory_uri() . '/assets/js/lib/splide/splide.min.js',
        [],
        null,
        true
      );
    }

    if (is_search() || queryy_is_blog_search_page()) {
      wp_enqueue_script(
        'articles',
        get_template_directory_uri() . '/assets/js/pages/articles.js',
        ['splide'],
        null,
        true
      );
    }

    if (is_singular('download-pdf')) {
      wp_enqueue_script(
        'glide',
        get_template_directory_uri() . '/assets/js/lib/glide/glide.min.js',
        [],
        null,
        true
      );
    }
    // $pageSlugと、slug名と一致したファイル名が存在していたらjs読み込みます。
    if (is_file($jsFileName) && !is_post_type_archive('download-pdf')) {
      $deps = [];
      if (in_array($pageSlug, ['front-page', 'home', 'author', 'date', 'writers', 'post'], true)) {
        $deps = ['splide'];
      } elseif ($pageSlug === 'download-pdf') {
        $deps = ['glide'];
      }

      wp_enqueue_script(
        $pageSlug,
        get_template_directory_uri() . '/assets/js/pages/' . $pageSlug . '.js',
        $deps,
        null,
        true
      );
    }
  }
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

/**
 * 自作エントリのみ type="module" を付与する。
 * - ライブラリ（splide/glide/gsap/axios等）は通常scriptのまま
 * - WPが生成するid等の属性は保持する
 */
function add_module_type_attribute($tag, $handle, $src) {
  // ページのスラッグを取得（my_enqueue_scripts と揃える）
  $pageSlug = '';
  if (is_front_page()) {
    $pageSlug = 'front-page';
  } elseif (is_home()) {
    $pageSlug = 'home';
  } elseif (is_page()) {
    $pageSlug = get_post(get_the_ID())->post_name;
  } elseif (is_author()) {
    $pageSlug = 'author';
  } elseif (is_date()) {
    $pageSlug = 'date';
  } elseif (is_404()) {
    $pageSlug = '404';
  } elseif (is_archive() || is_single()) {
    $post_type = get_post_type();
    $pageSlug = $post_type ? get_post_type_object($post_type)->name : '';
  }

  // moduleにしたい「自作エントリ」だけ
  $module_handles = ['app', 'articles'];
  if ($pageSlug) {
    $module_handles[] = $pageSlug;
  }
  if (!in_array($handle, $module_handles, true)) {
    return $tag;
  }

  return '<script type="module" src="' . esc_url($src) . '"></script>';
}
add_filter('script_loader_tag', 'add_module_type_attribute', 10, 3);
/********************************************

現行サイトから引用

 *********************************************/

/*---------------------------------------------
 * 絵文字機能無効化
 *--------------------------------------------*/
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/*---------------------------------------------
 * EWWW Image Optimizer noresizeを含んだ画像を圧縮処理やWebP生成の回避
 *--------------------------------------------*/
add_filter(
  'ewww_image_optimizer_bypass',
  function ($bypass, $filename) {
    if (strpos($filename, 'noresize') !== false) {
      return true;
    }
    return $bypass;
  },
  10,
  2
);

/*---------------------------------------------
 * アイキャッチ使用を宣言
 *--------------------------------------------*/
function my_awesome_image_resize_dimensions(
  $payload,
  $orig_w,
  $orig_h,
  $dest_w,
  $dest_h,
  $crop
) {
  if (false) {
    return $payload;
  }

  if ($crop) {
    $aspect_ratio = $orig_w / $orig_h;
    $new_w = min($dest_w, $orig_w);
    $new_h = min($dest_h, $orig_h);

    if (!$new_w) {
      $new_w = intval($new_h * $aspect_ratio);
    }
    if (!$new_h) {
      $new_h = intval($new_w / $aspect_ratio);
    }

    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = 0;
    $s_y = 0;
  } else {
    $crop_w = $orig_w;
    $crop_h = $orig_h;

    $s_x = 0;
    $s_y = 0;

    list($new_w, $new_h) = wp_constrain_dimensions(
      $orig_w,
      $orig_h,
      $dest_w,
      $dest_h
    );
  }

  if ($new_w >= $orig_w && $new_h >= $orig_h) {
    return false;
  }
  return [
    0,
    0,
    (int) $s_x,
    (int) $s_y,
    (int) $new_w,
    (int) $new_h,
    (int) $crop_w,
    (int) $crop_h,
  ];
}
add_filter(
  'image_resize_dimensions',
  'my_awesome_image_resize_dimensions',
  10,
  6
);
add_theme_support('post-thumbnails');
add_image_size('workthumb', 600, 600);
add_image_size('blogthumb', 912, 609, true);

/*---------------------------------------------
 * ショートコード [url] [tmp_dir] [get_tmp] [title]
 *--------------------------------------------*/
add_filter('widget_text', 'do_shortcode');

function shortcode_url() {
  return get_bloginfo('url');
}
add_shortcode('url', 'shortcode_url');

function shortcode_title() {
  return get_the_title();
}
add_shortcode('title', 'shortcode_title');

function shortcode_template_directory() {
  return get_template_directory_uri();
}
add_shortcode('tmp_dir', 'shortcode_template_directory');

function shortcode_get_template_part($atts) {
  extract(
    shortcode_atts(
      [
        'slug' => 'templates/part',
        'name' => '',
      ],
      $atts
    )
  );
  ob_start();
  get_template_part($slug, $name);
  // 	include_once( get_template_directory() ."/{$slug}-{$name}.php");
  return ob_get_clean();
}
add_shortcode('get_tmp', 'shortcode_get_template_part'); // 例 [get_tmp slug="templates/part" name="breadcrumb"]

function clearboth() {
  return "<br class='clear'>";
}
add_shortcode('clear', 'clearboth');

function blockFunc($atts, $content = null) {
  extract(
    shortcode_atts(
      [
        'ttl' => '',
        'url' => '',
      ],
      $atts
    )
  );
  return '<blockquote>' .
    $content .
    '</blockquote><cite>出典：<a href="' .
    $url .
    '">' .
    $ttl .
    '</a></cite>';
}
add_shortcode('block', 'blockFunc');

function subFunc($atts, $content = null) {
  return '<div class="detail-sub">' . $content . '</div>';
}
add_shortcode('sub', 'subFunc');

/*---------------------------------------------
 * メディア項目追加
 *--------------------------------------------*/
add_filter(
  'attachment_fields_to_edit',
  'otocon_attachment_credit_fields_to_edit',
  10,
  2
);
function otocon_attachment_credit_fields_to_edit($form_fields, $post) {
  $form_fields['photo_credit'] = [
    'label' => __('引用元サイト名'),
    'input' => 'text',
  ];
  $form_fields['credit_url'] = [
    'label' => __('引用元URL'),
    'input' => 'text',
    'value' => get_post_meta($post->ID, 'credit_url', true),
    'helps' => __('Set a credit URL for this attachment'),
  ];
  return $form_fields;
}

/*-- 内容を保存 --*/
add_filter('attachment_fields_to_save', 'otocon_edit_attachment', 10, 2);
function otocon_edit_attachment($post, $attachment) {
  if (isset($attachment['photo_credit'])) {
    update_post_meta($post['ID'], 'photo_credit', $attachment['photo_credit']);
  }
  if (isset($attachment['credit_url'])) {
    update_post_meta($post['ID'], 'credit_url', $attachment['credit_url']);
  }
  return $post;
}

add_filter('image_send_to_editor', 'otocon_image_send_to_editor', 10, 8);
function otocon_image_send_to_editor(
  $html,
  $id,
  $caption,
  $title,
  $align,
  $url,
  $size,
  $alt
) {
  $credit_true = get_post_meta($id, 'credit_url', true);
  if ($credit_true) {
    $credit =
      '<a href="' .
      esc_url(get_post_meta($id, 'credit_url', true)) .
      '" title="' .
      esc_attr(get_post_meta($id, 'photo_credit', true)) .
      '" class="external" target="_blank">' .
      esc_html(get_post_meta($id, 'photo_credit', true)) .
      '</a>';
    return '<figure class="wp-caption align' .
      esc_attr($align) .
      ' attachment-' .
      $id .
      '">' .
      $html .
      '<figcaption class="wp-caption-text">出典：' .
      $credit .
      '</figcaption></figure>';
  } else {
    return '<figure class="wp-caption align' .
      esc_attr($align) .
      ' attachment-' .
      $id .
      '">' .
      $html .
      '</figure>';
  }
}

/*---------------------------------------------
 * ビジュアルエディターcss読み込み
 *--------------------------------------------*/
add_editor_style('editor-style.css');

function custom_editor_settings($initArray) {
  $initArray['body_class'] = 'editor-area';
  return $initArray;
}

add_filter('tiny_mce_before_init', 'custom_editor_settings');

/********************************************

管理画面の設定ファイル

 *********************************************/

/*--------------------------------------------------------------
Get first term of post
--------------------------------------------------------------*/
function get_first_term($taxonomy) {
  global $post;
  if ($terms = get_the_terms($post->ID, $taxonomy)) {
    return array_pop($terms);
  }
}
/*--------------------------------------------------------------
特定の親ページと、その子ページにのみ条件
--------------------------------------------------------------*/
function is_parent_slug() {
  global $post;
  if ($post && property_exists($post, 'post_parent')) {
    $post_data = get_post($post->post_parent);
    return $post_data->post_name;
  }
}
/*--------------------------------------------------------------
日本語スラッグを自動的に英字スラッグに書き換える
--------------------------------------------------------------*/
function auto_post_slug($slug, $post_ID, $post_status, $post_type) {
  if (preg_match('/(%[0-9a-f]{2})+/', $slug)) {
    $slug = utf8_uri_encode($post_type) . '-' . $post_ID;
  }
  return $slug;
}
add_filter('wp_unique_post_slug', 'auto_post_slug', 10, 4);
/*--------------------------------------------------------------
不要なメニュー非表示
--------------------------------------------------------------*/
add_action('admin_menu', 'remove_menus');
function remove_menus() {
  remove_menu_page('edit-comments.php'); //コメントメニュー
}
/*--------------------------------------------------------------
WP バージョン隠す
--------------------------------------------------------------*/
function remove_cssjs_ver1($src) {
  if (strpos($src, 'ver=' . get_bloginfo('version'))) {
    $src = remove_query_arg('ver', $src);
  }
  return $src;
}
add_filter('style_loader_src', 'remove_cssjs_ver1', 9999);
add_filter('script_loader_src', 'remove_cssjs_ver1', 9999);

remove_action('wp_head', 'wp_generator');
/*--------------------------------------------------------------
現在の投稿タイプと一致すればcurrentクラスを出力
--------------------------------------------------------------*/
function the_current_post_type_class($post_type) {
  if (get_post_type() == $post_type) {
    echo 'is-current';
  }
}
/*--------------------------------------------------------------
現在のページとパスが一致すればcurrentクラスを出力
--------------------------------------------------------------*/
function the_current_page_class($path) {
  global $post;
  if ($page = get_page_by_path($path)) {
    if ($page->ID == $post->ID) {
      echo 'is-current';
    }
  }
}
/*--------------------------------------------------------------
currentクラスを出力(子ページも含む)
--------------------------------------------------------------*/
function e_current($slug, $post = null) {
  $parent = null;
  if ($post && property_exists($post, 'post_parent')) {
    $parent = get_post_field('post_name', $post->post_parent);
  }
  if (
    $slug === $parent ||
    is_page($slug) ||
    is_singular($slug) ||
    is_post_type_archive($slug) ||
    is_tax($slug)
  ) {
    echo 'is-current';
  }

  return false;
}
/*--------------------------------------------------------------
// 親ページ（最上位）のスラッグを取得
--------------------------------------------------------------*/
function root_slug($current_id) {
  $ancestors = get_post_ancestors($current_id); // 親のIDを取得
  $root_id = end($ancestors); // 最上位の親のIDを取得
  $root_slug = get_post_field('post_name', $root_id); // 最上位の親のスラッグを取得

  return $root_slug;
}

/*--------------------------------------------------------------
表示件数を変更
--------------------------------------------------------------*/
function change_posts_per_page($query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  if (
    $query->is_post_type_archive('download-pdf') ||
    $query->is_tax('download-pdf_cate')
  ) {
    $query->set('posts_per_page', '12'); //資料ダウンロード
  }
}
add_action('pre_get_posts', 'change_posts_per_page');

function my_restrict_admin() {
  global $user_level;
  if ($user_level < 1) {
    wp_redirect(get_post_type_archive_link('download-pdf'));
    wp_redirect(get_post_type_archive_link('cases'));
    exit();
  }
}
add_action('admin_init', 'my_restrict_admin');

/*--------------------------------------------------------------
検索フォーム search.php 変更
--------------------------------------------------------------*/
//
add_action('template_include', 'my_search_template');
function my_search_template($template) {
  $type = filter_input(INPUT_GET, 'search_type');
  $new_template = '';
  if ($type) {
    switch ($type) {
      case 'blog':
        $new_template = STYLESHEETPATH . '/search-blog.php';
        break;
      default:
        $new_template = '';
    }
  }
  if ($new_template) {
    if (file_exists($new_template)) {
      return $new_template;
    }
  }
  return $template;
}
/*--------------------------------------------------------------
パンクズリスト search.php 変更
--------------------------------------------------------------*/
function my_static_breadcrumb_adder($breadcrumb_trail) {
  if (queryy_is_blog_search_page()) {
    $stuck = array_pop($breadcrumb_trail->breadcrumbs);
    $breadcrumb_trail->breadcrumbs[] = $stuck;
  }
}
add_action('bcn_after_fill', 'my_static_breadcrumb_adder');
/*--------------------------------------------------------------
Yoast SEOの変更
--------------------------------------------------------------*/

function custom_wpseo_title($title) {
  $current_url = $_SERVER['REQUEST_URI'] ?? '';
  $path = $current_url ? wp_parse_url($current_url, PHP_URL_PATH) : '';
  $site_title = get_bloginfo('name');
  if (is_month()) {
    $title = get_the_date('Y年n月') . 'の記事一覧 | ' . $site_title;
  }
  if ($path && (strpos($path, '/search') === 0 || strpos($path, '/articles/search') === 0)) {
    $searchBlogCategory = isset($_GET['cat']) ? $_GET['cat'] : '';
    $title = '';
    if (get_search_query()) {
      $title .= '「' . get_search_query() . '」';
    }
    if ($searchBlogCategory) {
      $cat_name = get_category($searchBlogCategory);
      $title .= '「' . $cat_name->name . '」';
    }
    $title .= 'の検索結果 | ' . $site_title;
  }
  return $title;
}
add_filter('wpseo_title', 'custom_wpseo_title');

function custom_metadesc($metadesc) {
  if (is_month()) {
    $metadesc =
      get_the_date('Y年n月') .
      'の記事一覧。QUERYY(クエリー)はSEOやウェブ広告、WEB制作のお役立ち情報まで、WEBマーケティングで役立つ情報を提供するニュートラルワークスのデジタルマーケティングメディアです。';
  }
  return $metadesc;
}
add_filter('wpseo_metadesc', 'custom_metadesc');

/*--------------------------------------------------------------
Yoast SEO page-sitemap.xmlリライトルール追加
--------------------------------------------------------------*/
function yoast_rewrite_rule() {
  add_rewrite_rule('page_sitemap.xml', 'index.php?sitemap=page', 'top');
}
add_action('init', 'yoast_rewrite_rule');

/**
 * Writes additional/custom XML sitemap strings to the XML sitemap index.
 *
 * @param string $sitemap_custom_items XML describing one or more custom sitemaps.
 *
 * @return string The XML sitemap index with the additional XML.
 */
function add_sitemap_custom_items($sitemap_custom_items) {
  $sitemap_custom_items .=
    '
<sitemap>
<loc>' .
    home_url() .
    '/page_sitemap.xml</loc>
<lastmod>2017-05-22T23:12:27+00:00</lastmod>
</sitemap>';
  return $sitemap_custom_items;
}

add_filter('wpseo_sitemap_index', 'add_sitemap_custom_items');

/*--------------------------------------------------------------
// オプションページのインタースティシャルバナー情報を取得する
// REST APIエンドポイントを登録
--------------------------------------------------------------*/
add_action('rest_api_init', 'register_custom_banner_endpoint');
function register_custom_banner_endpoint() {
    // /wp-json/custom/v1/banner というエンドポイントを作成
    register_rest_route('custom/v1', '/banner', array(
        'methods' => 'GET',
        'callback' => 'get_banner_data',
        'permission_callback' => '__return_true', // 誰でもアクセスできるように
    ));
}

// オプションページのデータを取得するコールバック関数
function get_banner_data() {
    // ACFが有効でない場合は、エラーメッセージを返す
    if (!function_exists('get_field')) {
        return new WP_Error('acf_inactive', 'ACF is inactive', array('status' => 404));
    }

    // オプションページからACFフィールドを取得
    $bannerInfoArray = [
        'image' => null,
        'url' => null,
    ];

    $interstitialBannerfromSettings = get_field('interstitial_banner', 'option');

    if (
        $interstitialBannerfromSettings['interstitial_banner_image'] &&
        $interstitialBannerfromSettings['interstitial_banner_url']
    ) {
        $bannerInfoArray = [
            'image' => $interstitialBannerfromSettings['interstitial_banner_image']['url'],
            'url' => $interstitialBannerfromSettings['interstitial_banner_url']['url'],
        ];
    }

    return $bannerInfoArray;
}

// カスタムフィールド "メディア 関連サービスへの動線" を記事内に挿入する
function insert_related_services_links_before_toc($content) {
  // カスタムフィールドの値を取得
  $custom_field_value = get_post_meta(get_the_ID(), 'related_services_links', true);
  // カスタムフィールドの値が存在しない場合は処理を終了
  if (empty($custom_field_value)) {
      return $content;
  }
  // Table of Contents Plusの目次が存在するかチェック
  if (strpos($content, 'toc_container') !== false) {
      // 目次の前にカスタムフィールドを挿入
      $content = str_replace('<div id="toc_container"', $custom_field_value . '<div id="toc_container"', $content);
  } else {
      // 最初の見出しの直前にカスタムフィールドを挿入
      $content = preg_replace('/(<h[1-6][^>]*>)/i', $custom_field_value . '$1', $content, 1);
  }
  return $content;
}
add_filter('the_content', 'insert_related_services_links_before_toc');

// カテゴリー編集画面の「親カテゴリー」を非表示（UIのみ）
add_action('admin_head', function() {
  if ( !function_exists('get_current_screen') ) return;
  $screen = get_current_screen();
  if ( !$screen ) return;

  // 「投稿 > カテゴリー」(edit-tags.php) と、個別編集(term.php) のみ対象
  if (
      in_array($screen->base, ['edit-tags', 'term'], true) &&
      in_array(($screen->taxonomy ?? ''), ['category', 'download-pdf_cate'], true)
    ) {
    echo '<style>
      /* 追加・編集フォームの親カテゴリー */
      .term-parent-wrap { display:none !important; }
    </style>';
  }
});
