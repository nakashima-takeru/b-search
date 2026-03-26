<?php
/*---------------------------------------------
 * RSSの記事URLを変更
 *--------------------------------------------*/
function external_the_permalink_rss($get_permalink) {
  global $post;
  $categories = get_the_category($post->ID);
  return home_url() .
    $categories[0]->slug .
    '/' .
    $post->post_name .
    '/';
}
add_filter('the_permalink_rss', 'external_the_permalink_rss', 10, 2);
function external_comments_link_feed($get_permalink) {
  global $post;
  $categories = get_the_category($post->ID);
  return home_url() .
    $categories[0]->slug .
    '/' .
    $post->post_name .
    '/#respond';
}
add_filter('comments_link_feed', 'external_comments_link_feed', 10, 2);

/*---------------------------------------------
 * 表示されるクイックタグを調整
 *--------------------------------------------*/
add_filter('quicktags_settings', function($qt_init, $editor_id) {
  if ($editor_id !== 'content' && $editor_id !== 'classic-block') {
    return $qt_init;
  }

  if (empty($qt_init['buttons'])) {
    return $qt_init;
  }

  $buttons = array_filter(array_map('trim', explode(',', $qt_init['buttons'])));
  // codeタグ・moreタグを非表示に
  $buttons = array_values(array_diff($buttons, ['code', 'more']));

  $qt_init['buttons'] = implode(',', $buttons);

  return $qt_init;
}, 10, 2);

/*---------------------------------------------
 * クイックタグにブログカード,CTAボタン,ダウンロードリンク,カルーセルフォーム,補助金チャート,関連記事リストを追加
 *--------------------------------------------*/
function themes_add_quicktags() {
  if (wp_script_is('quicktags')) {
    $html = '<script>';
    $html .=
      'QTags.addButton( "BlogCard", "BlogCard", "[BlogCard url=\"ブログURLを入力してください\"]", "", "BlogCard", "BlogCard", 120 );';
    $html .=
      'QTags.addButton( "CTAButton", "CTAButton", "[CTAButton url=\"ブログURLを入力してください\" title=\"タイトルを入力してください\"]", "", "CTAButton", "CTAButton", 120 );';
    $html .=
      'QTags.addButton( "DownloadLink", "DownloadLink", "[DownloadLink title=\"タイトルを入力してください\" description=\"説明を入力してください\" link_url=\"URLを入力してください\" link_text=\"テキストを入力してください\" image_url=\"300x200サイズの画像URLを入力してください\" image_alt=\"画像の説明を入力してください\"]", "", "DownloadLink", "DownloadLink", 122 );';
    $html .=
      'QTags.addButton( "CarouselForm", "CarouselForm", "[CarouselForm id=\"Form IDを入力してください\" name=\"valueを入力してください\" title=\"見出しを入力してください\" description=\"説明を入力してください\"]", "", "CarouselForm", "CarouselForm", 123 );';
    $html .=
      'QTags.addButton( "SimpleTable", "SimpleTable", "\n[SimpleTable row_th=\"0\"]\n商品名|価格|備考\nA|1000|メモ\nB|2000|メモ\n[/SimpleTable]\n", "", "", "シンプルなテーブルタグの挿入", 124 );';
    $html .= '</script>';
    echo $html;
  }
}
add_action('admin_print_footer_scripts', 'themes_add_quicktags', 100);

/*---------------------------------------------
 * ショートコードにブログカードを追加
 *--------------------------------------------*/
function shortcode_blogcard($atts) {
  extract(shortcode_atts(['url' => ''], $atts));
  $url = rtrim(esc_attr($url), '/');
  $url_items = explode('/', $url);
  $slug = end($url_items);
  $args = [
    'name' => $slug,
    'post_type' => 'post',
    'posts_per_page' => 1,
  ];
  $posts = get_posts($args);
  if (count($posts) == 0) {
    return;
  }
  $thumbnail_id = get_post_thumbnail_id($posts[0]->ID);
  $thumbnail_img = $thumbnail_id
    ? wp_get_attachment_image_src($thumbnail_id, 'medium')
    : ['https://n-works.link/nuxt/image/dammy-300x200.jpg', 300, 200];
  ob_start();
  ?>
    <a href="<?php echo $url; ?>" class="blog-card">
	    <span class="blog-card__image">
        <img src="<?php echo $thumbnail_img[0]; ?>" width="<?php echo $thumbnail_img[1]; ?>" height="<?php echo $thumbnail_img[2]; ?>" alt="<?php echo $posts[0]->post_title; ?>" class="thumbnail" loading="lazy" />
	    </span>
	    <span class="blog-card__info">
        <span class="blog-card__title"><?php echo $posts[0]
          ->post_title; ?></span>
        <span class="blog-card__description"><?php echo $posts[0]
          ->post_excerpt; ?></span>
	    </span>
	  </a>
    <?php return ob_get_clean();
}
add_shortcode('BlogCard', 'shortcode_blogcard');

/*---------------------------------------------
 * ショートコードにカルーセルフォームを追加
 *--------------------------------------------*/
function shortcode_carouselform($atts) {
  $carousel_form_id = uniqid('cf_');

  extract(
    shortcode_atts(
      [
        'id' => '',
        'name' => '',
        'title' => '',
        'description' => '',
      ],
      $atts
    )
  );
  ob_start();
  ?>
    <div class="s-carousel-form-box js-carousel-form" data-form-id="<?php echo esc_attr(
      $id
    ); ?>" data-form-name="<?php echo esc_attr($name); ?>" data-step="1">
      <header class="s-carousel-form-box__header">
        <p class="s-carousel-form-box__label">＜無料＞資料ダウンロード</p>
        <p class="s-carousel-form-box__title"><?php echo esc_html(
          $title
        ); ?></p>
        <p class="s-carousel-form-box__description"><?php echo esc_html(
          $description
        ); ?></p>
      </header>
      <div class="s-carousel-form-box-step">
        <div class="s-carousel-form-box-step__bg-line"></div>
        <div class="s-carousel-form-box-step__inner">
          <span class="s-carousel-form-box-step__point"></span>
          <span class="s-carousel-form-box-step__point"></span>
          <span class="s-carousel-form-box-step__point"></span>
          <span class="s-carousel-form-box-step__point"></span>
          <span class="s-carousel-form-box-step__point"></span>
        </div>
      </div>
      <form action="" name="<?php echo esc_attr(
        $carousel_form_id
      ); ?>" class="s-carousel-form stack20">
        <ul class="s-carousel-form__list">
          <li class="s-carousel-form-item required stack10 js-form-item-parent">
            <label for="lastname_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" class="s-carousel-form-item__header">
              <span class="step">Step 1</span>
              <span>お名前をご入力ください（全角）</span>
            </label>
            <input type="text" id="lastname_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" placeholder="ニュートラル 太郎" class="s-carousel-form-item__input js-carousel-form__lastname" required/>
            <p class="errorText"></p>
          </li>
          <li class="s-carousel-form-item required stack10 js-form-item-parent">
            <label for="email_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" class="s-carousel-form-item__header">
              <span class="step">Step 2</span>
              <span>メールアドレスをご入力ください（半角英数字記号）</span>
            </label>
            <input type="email" id="email_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" placeholder="taro@nworks.link" class="s-carousel-form-item__input js-carousel-form__email" required/>
            <p class="errorText"></p>
          </li>
          <li class="s-carousel-form-item stack10 js-form-item-parent">
            <label for="phone_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" class="s-carousel-form-item__header">
              <span class="step">Step 3</span>
              <span> 電話番号をご入力ください（半角数字及びハイフン）</span>
            </label>
            <input type="tel" id="phone_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" placeholder="0466-30-5070" class="s-carousel-form-item__input js-carousel-form__phone" required/>
            <p class="errorText"></p>
          </li>
          <li class="s-carousel-form-item stack10 js-form-item-parent">
            <label for="company_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" class="s-carousel-form-item__header">
              <span class="step">Step 4</span>
              <span>会社名をご入力ください（全角または半角英数字記号）</span>
            </label>
            <input type="text" id="company_<?php echo esc_attr(
              $carousel_form_id
            ); ?>" placeholder="株式会社ニュートラルワークス" class="s-carousel-form-item__input js-carousel-form__company" required/>
            <p class="errorText"></p>
          </li>
          <li class="s-carousel-form-item js-form-item-parent stack10">

          <fieldset class="stack10 js-carousel-form__price_pulldown" data-group="selectGroup">
                                        <label for="price_pulldown_<?php echo esc_attr(
                    $carousel_form_id
                  ); ?>" class="s-carousel-form-item__header">
                                            想定ご予算
                                        </label>

                                        <select id="price_pulldown_<?php echo esc_attr(
                    $carousel_form_id
                  ); ?>" required class="hs-input is-placeholder" name="price_pulldown">
                                            <option disabled value>選択してください</option>
                                            <option value="～10万円">～10万円</option>
                                            <option value="11万円～30万円">11万円～30万円</option>
                                            <option value="31万円～50万円">31万円～50万円</option>
                                            <option value="51万円～100万円">51万円～100万円</option>
                                            <option value="101万円～300万円">101万円～300万円</option>
                                            <option value="301万円～">301万円～</option>
                                            <option value="わからない">わからない</option>
                                        </select>
                                    </fieldset>
            <!-- <fieldset class="stack10 js-carousel-form__budget" data-group="radioGroup">
              <legend class="s-carousel-form-item__header">
                <span class="step">Step 5</span>
                <span>想定のご予算</span>
              </legend>
              <div class="radio-wrapper" >
                <label class="radioItem">
                  <input type="radio" name="budget_<?php echo esc_attr(
                    $carousel_form_id
                  ); ?>" value="～10万円" required>
                  <span class="radioItem__icon"></span>
                  <span class="radioItem__label">～10万円</span>
                </label>
                <label class="radioItem">
                  <input type="radio" name="budget_<?php echo esc_attr(
                    $carousel_form_id
                  ); ?>" value="11万円～100万円">
                  <span class="radioItem__icon"></span>
                  <span class="radioItem__label">11万円～100万円</span>
                </label>
                <label class="radioItem">
                  <input type="radio" name="budget_<?php echo esc_attr(
                    $carousel_form_id
                  ); ?>" value="101万円～">
                  <span class="radioItem__icon"></span>
                  <span class="radioItem__label">101万円～</span>
                </label>
              </div>
            </fieldset> -->
            <p class="errorText"></p>
          </li>
        </ul>
        <div class="s-carousel-form__return">
          <button type="button" class="s-carousel-form__return-button js-carousel-form-return">
            <div class="icon">
              <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                <path d="M7.19998 0.799999L1.59998 4L7.19998 7.2" stroke="currentColor"></path>
              </svg>
            </div>
            <span>戻る</span>
          </button>
        </div>
        <div>
          <div class="s-carousel-form__button next">
            <div class="buttonItem" data-color="orange">
              <button type="button" class="buttonItem__link js-carousel-form-next">
                <span>次へ</span>
              </button>
            </div>
          </div>
          <div class="s-carousel-form__button submit">
            <div class="buttonItem" data-color="green">
              <button type="button" class="buttonItem__link js-carousel-form-submit">
                <span>資料をダウンロード</span>
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  <?php return ob_get_clean();
}
add_shortcode('CarouselForm', 'shortcode_carouselform');

/*---------------------------------------------
 * ショートコードにCTAボタンを追加
 *--------------------------------------------*/
function shortcode_ctabutton($atts) {
  extract(
    shortcode_atts(
      [
        'url' => '',
        'title' => '',
      ],
      $atts
    )
  );
  ob_start();
  ?>
    <div class="ctaButton">
      <div class="ctaButton__inner">
        <a href="<?php echo esc_attr($url); ?>" class="ctaButton__link">
          <span class="ctaButton__ico">
            <span class="ctaButton__ico--enter">
              <svg class="svg-arrow" astro-icon="arrow">
                <use xlink:href="#astroicon:arrow"></use>
              </svg>
            </span>
            <span class="ctaButton__ico--leave">
              <svg class="svg-arrow" astro-icon="arrow">
                <use xlink:href="#astroicon:arrow"></use>
              </svg>
            </span>
          </span>
          <span><?php echo esc_html($title); ?></span>
        </a>
      </div>
    </div>
  <?php return ob_get_clean();
}
add_shortcode('CTAButton', 'shortcode_ctabutton');

/*---------------------------------------------
 * ショートコードにCTAエリアを追加
 *--------------------------------------------*/
function shortcode_downloadLink($atts) {
  extract(
    shortcode_atts(
      [
        'title' => '',
        'description' => '',
        'link_url' => '',
        'link_text' => '',
        'image_url' => '',
        'image_alt' => '',
      ],
      $atts
    )
  );
  ob_start();
  ?>
    <div class="downloadLink">
      <p class="downloadLink__title">
        <?php echo $title; ?>
      </p>
      <div class="downloadLink__body">
        <p><?php echo $description; ?></p>
        <div class="downloadLink__card">
          <a href="<?php echo esc_url($link_url); ?>">
            <div class="downloadLink__image">
              <img src="<?php echo esc_url(
                $image_url
              ); ?>" alt="<?php echo esc_attr($image_alt ? $image_alt : $link_text); ?>" width="300" height="200" loading="lazy">
            </div>
            <p class="downloadLink__link-text">
              <?php echo wp_kses_post($link_text); ?>
            </p>
          </a>
        </div>
      </div>
    </div>
  <?php return ob_get_clean();
}

add_shortcode('DownloadLink', 'shortcode_downloadLink');

/**
 * ショートコードにテーブルタグを追加
 *
 * [table] 商品名|価格|備考 ... [/table]
 * 1行目をthead、2行目以降をtbodyにします。
 * オプション: row_th="1" で「各行の1列目を<th>」にできます。
 */
function shortcode_simpleTable($atts, $content = null, $tag = '') {
  $atts = shortcode_atts([
    'class' => '',
    'row_th' => '0' // tbodyの先頭を<th scope="row">にする
  ], $atts, $tag);

  if ($content === null) return;

  // 改行統一
  $content = trim($content);
  $content = preg_replace("/\r\n?/", "\n", $content);
  $content = str_ireplace(["<br />", "<br/>", "<br>"], "\n", $content);

  $lines = array_values(array_filter(array_map('trim', explode("\n", $content)), 'strlen'));
  if (!$lines) return;

  $rows = [];
  foreach($lines as $line) {
    $cols = array_map('trim', explode("|", $line));

    if (count($cols) && $cols[0] === "") array_shift($cols);
    if (count($cols) && end($cols) === "") array_pop($cols);

    $hasValue = false;
    foreach($cols as $c) {
      if ($c !== "") {
        $hasValue = true;
        break;
      }
    }
    if ($hasValue) $rows[] = $cols;
  }
  if (!$rows) return '';

  $rowTh = ($atts['row_th'] === '1');

  $thead = null;
  if (count($rows) >= 1) {
    $thead = array_shift($rows);
  }

  $sanitize_cell = function($text) {
    return wp_kses_post($text);
  };

  $classes = $atts['class'];

  ob_start();
  ?>
  <table class="<?php echo esc_attr($classes); ?>">
    <thead>
      <tr>
        <?php foreach($thead as $cell): ?>
          <th scope="col"><?php echo $sanitize_cell($cell); ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach($rows as $r): ?>
        <tr>
          <?php foreach($r as $i => $cell): ?>
            <?php if ($rowTh && $i === 0): ?>
              <th scope="row"><?php echo $sanitize_cell($cell); ?></th>
            <?php else: ?>
              <td><?php echo $sanitize_cell($cell); ?></td>
            <?php endif; ?>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php return ob_get_clean();
}
add_shortcode('SimpleTable', 'shortcode_simpleTable');

/*---------------------------------------------
 * 投稿のアーカイブページを設定
 *--------------------------------------------*/

add_filter(
  'register_post_type_args',
  function ($args, $post_type) {
    if ($post_type === 'post') {
      global $wp_rewrite;
      $archive_slug = 'articles';
      $args['label'] = 'メディア';
      $args['has_archive'] = false;
      $archive_slug = $wp_rewrite->root . $archive_slug;
      $feeds = '(' . trim(implode('|', $wp_rewrite->feeds)) . ')';
    }
    return $args;
  },
  10,
  2
);

/*---------------------------------------------
 *  blogのみ、Block editor を無効化
 *--------------------------------------------*/
add_filter(
  'use_block_editor_for_post',
  function ($use_block_editor, $post) {
    if ('post' === $post->post_type) {
      $use_block_editor = false;
    }
    return $use_block_editor;
  },
  10,
  2
);

/*---------------------------------------------
 *  リライトルール追加 category・tag
 *--------------------------------------------*/
function custom_rewrite_rule() {
  // カテゴリーベースを外しているため、カテゴリーページの /page/2/ 以降を先に解決する
  add_rewrite_rule(
    '(?!articles|download-pdf|download-pdf_cate|writers)(.+?)/page/?([0-9]{1,})/?$',
    'index.php?category_name=$matches[1]&paged=$matches[2]',
    'top'
  );

  // カスタム投稿タイプ / タクソノミーのページネーション（上の汎用ルールに奪われないように明示）
  add_rewrite_rule(
    'download-pdf/page/?([0-9]{1,})/?$',
    'index.php?post_type=download-pdf&paged=$matches[1]',
    'top'
  );

  add_rewrite_rule(
    'download-pdf_cate/(.+?)/page/?([0-9]{1,})/?$',
    'index.php?download-pdf_cate=$matches[1]&paged=$matches[2]',
    'top'
  );

  add_rewrite_rule(
    'writers/page/([0-9]+)/?$',
    'index.php?pagename=writers&paged=$matches[1]',
    'top'
  );
  add_rewrite_rule(
    'writers/([^/]+)/?$',
    'index.php?author_name=$matches[1]',
    'top'
  );
  add_rewrite_rule(
    'writers/([^/]+)/page/?([0-9]+)/?$',
    'index.php?author_name=$matches[1]&paged=$matches[2]',
    'top'
  );
  add_rewrite_rule(
    'tag/([^/]+)/page/?([0-9]{1,})/?$',
    'index.php?tag=$matches[1]&paged=$matches[2]',
    'top'
  );
  add_rewrite_rule(
    '(.+?)/embed/?$',
    'index.php?category_name=$matches[1]&name=$matches[2]&embed=true',
    'top'
  );
  add_rewrite_rule(
    '(.+?)/(feed|rdf|rss|rss2|atom)/?$',
    'index.php?category_name=$matches[1]&name=$matches[2]&feed=$matches[3]',
    'top'
  );
  add_rewrite_rule(
    '(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$',
    'index.php?category_name=$matches[1]&name=$matches[2]&feed=$matches[3]',
    'top'
  );
  add_rewrite_rule(
    'search/(.+)/page/?([0-9]{1,})/?$',
    'index.php?s=$matches[1]&paged=$matches[2]',
    'top'
  );
  add_rewrite_rule(
    'articles/page/([0-9]{1,})/?$',
    'index.php?pagename=$matches[1]&paged=$matches[2]',
    'top'
  );
}
add_action('init', 'custom_rewrite_rule');

/*---------------------------------------------
 *  get_category_link関数をカスタマイズして/category/プレフィックスを除去
 *--------------------------------------------*/
function custom_category_link($link, $category) {
  // /category/プレフィックスを除去して/カテゴリー名の形式に変更
  return str_replace('/category/', '/', $link);
}
add_filter('category_link', 'custom_category_link', 10, 2);

/*--------------------------------------------------------------
Newバッジが必要かどうかを判別する関数です。
最新更新日からの経過日数に応じて判別しています。
ループ内で使用する想定です。
--------------------------------------------------------------*/
function is_new_badge_needed() {
  $limit = 7;
  $today = wp_date('U');
  $modifiedTime = get_the_modified_time('U');
  $elapesedDays = date('U', $today - $modifiedTime) / (24 * 60 * 60);
  return $elapesedDays < $limit;
}

/**
 * パンくず（プラグイン Breadcrumb NavXT）をカスタマイズするための関数です。
 */
function bcn_add($breadcrumbTrail) {
  if (
    is_post_type_archive('post') ||
    is_category() ||
    is_tag() ||
    is_singular('post') ||
    (get_post_type() === 'post' && is_date())
  ) {
    $stuck = array_pop($breadcrumbTrail->breadcrumbs);
    $breadcrumbTrail->breadcrumbs[] = $stuck;
  }

  if (
    is_post_type_archive('post') &&
    !is_category() &&
    !is_author() &&
    !is_date()
  ) {
    $item = new bcn_breadcrumb('記事一覧', null, []);

    array_unshift($breadcrumbTrail->breadcrumbs, $item);
  }

  if (is_author()) {
    $url = home_url('/writers');

    if (count($breadcrumbTrail->breadcrumbs) > 0) {
      for ($i = 0; $i < count($breadcrumbTrail->breadcrumbs); $i++) {
        if (
          '著者・監修者一覧' === $breadcrumbTrail->breadcrumbs[$i]->get_title()
        ) {
          $breadcrumbTrail->breadcrumbs[$i]->set_url($url);
        }
      }
    }
  }
}
add_action('bcn_after_fill', 'bcn_add');

/*--------------------------------------------------------------
メディア用、表示件数を変更
--------------------------------------------------------------*/
function queryy_change_posts_per_page($query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  if (
    is_post_type_archive('post') ||
    is_page('articles') ||
    queryy_is_blog_search_page()
  ) {
    $query->set('posts_per_page', '2'); // メディア全記事一覧
    // デバッグ用: 設定が適用されているか確認
    // error_log('メディア posts_per_page set to: ' . $query->get('posts_per_page'));
  }

  if ($query->is_author()) {
    $query->set('posts_per_page', '6'); // 投稿者アーカイブページ
  }
}
add_action('pre_get_posts', 'queryy_change_posts_per_page');

/*--------------------------------------------------------------
Yoast SEO メディア詳細 パンクズ構造化データの変更
--------------------------------------------------------------*/
add_filter('wpseo_breadcrumb_links', 'custom_breadcrumbs');
// 共通の処理を関数に抽出
function add_common_breadcrumbs(
  &$links,
  $custom_breadcrumb_url,
  $custom_breadcrumb_name
) {
  $breadcrumb[] = [
    'url' => home_url(),
    'text' => 'TOP',
  ];
  array_splice($links, 0, -2, $breadcrumb);
  $breadcrumb[] = [
    'url' => $custom_breadcrumb_url,
    'text' => $custom_breadcrumb_name,
  ];
  array_splice($links, 0, -1, $breadcrumb);
}

function custom_breadcrumbs($links) {
  global $post;
  if (is_singular('post')) {
    if (has_tag() === true) {
      // post_tag 「タグ」 設定されている場合
      $tags = get_the_tags($post->ID);
      $filterdTags = [];
      foreach ($tags as $tag) {
        $isDisplay = get_field('custom_breadcrumb', $tag);
        $isUrl = $isDisplay['custom_breadcrumb_url'];
        // 遷移先URLの設定がされいない場合はスキップ
        if ($isUrl) {
          if ($isDisplay['custom_breadcrumb_select']['value'] === 'yes') {
            // 優先ありの場合
            array_push($filterdTags, $tag);
            $priority01_custom_breadcrumb_url =
              $isDisplay['custom_breadcrumb_url'];
            $priority01_custom_breadcrumb_name =
              $isDisplay['custom_breadcrumb_title'];
          } else {
            // 優先なしの場合
            $priority02_custom_breadcrumb_url =
              $isDisplay['custom_breadcrumb_url'];
            $priority02_custom_breadcrumb_name =
              $isDisplay['custom_breadcrumb_title'];
          }
        }
      }

      if ($isUrl) {
        // 遷移先URLが設定されている場合
        if (!empty($filterdTags)) {
          // 優先ありの場合
          $custom_breadcrumb_url = $priority01_custom_breadcrumb_url;
          $custom_breadcrumb_name = $priority01_custom_breadcrumb_name;
          $breadcrumb[] = [
            'url' => home_url(),
            'text' => 'TOP',
          ];
          array_splice($links, 0, -2, $breadcrumb);

          $breadcrumb[] = [
            'url' => $custom_breadcrumb_url,
            'text' => $custom_breadcrumb_name,
          ];
          array_splice($links, 0, -1, $breadcrumb);
        } else {
          // 優先なしの場合
          $custom_breadcrumb_url = $priority02_custom_breadcrumb_url;
          $custom_breadcrumb_name = $priority02_custom_breadcrumb_name;
          $breadcrumb[] = [
            'url' => home_url(),
            'text' => 'TOP',
          ];
          array_splice($links, 0, -2, $breadcrumb);

          $breadcrumb[] = [
            'url' => $custom_breadcrumb_url,
            'text' => $custom_breadcrumb_name,
          ];
          array_splice($links, 0, -1, $breadcrumb);
        }
      } else {
        // 遷移先URLの設定がされいない場合は共通の処理
        $category = get_the_category($post->ID);
        $custom_breadcrumb_url = home_url() . '/' . $category[0]->slug;
        $custom_breadcrumb_name = $category[0]->cat_name;
        add_common_breadcrumbs(
          $links,
          $custom_breadcrumb_url,
          $custom_breadcrumb_name
        );
      }
    } else {
      // post_tag 「タグ」 未設定の場合は共通の処理
      $category = get_the_category($post->ID);
      $custom_breadcrumb_url = home_url() . '/' . $category[0]->slug;
      $custom_breadcrumb_name = $category[0]->cat_name;
      add_common_breadcrumbs(
        $links,
        $custom_breadcrumb_url,
        $custom_breadcrumb_name
      );
    }
  }
  return $links;
}

/*--------------------------------------------------------------
WP-PageNaviプラグインの設定
--------------------------------------------------------------*/
function queryy_wp_pagenavi_settings() {
  // WP-PageNaviプラグインが有効かチェック
  if (function_exists('wp_pagenavi')) {
    // ページネーションの設定をカスタマイズ
    add_filter('wp_pagenavi_args', function($args) {
      $args['prev_text'] = '前へ';
      $args['next_text'] = '次へ';
      $args['mid_size'] = 2;
      $args['end_size'] = 1;
      return $args;
    });
  }
}
add_action('init', 'queryy_wp_pagenavi_settings');
