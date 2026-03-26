<?php
get_header();
$hubspotId = get_field('hubspot-id');
$postType = $post->post_type;
$postTypeSlug = get_post_type_object($postType)->name;
$taxName = $postTypeSlug . '_cate';

// GIFサムネイル用
// カスタムフィールド名
$custom_field_name = 'thumb_gif';
// カスタムフィールドが有効かチェックして値を取得
$gif_id = function_exists('get_post_meta') ? get_post_meta(get_the_ID(), $custom_field_name, true) : '';
// GIFのURLを取得
$gif_url = is_numeric($gif_id) ? wp_get_attachment_url($gif_id) : $gif_id;
// is-gif クラスを付与する条件
$is_gif_class = !empty($gif_url) ? 'is-gif' : '';
// 記事タイトルを取得
$post_title = get_the_title();
?>
    <?php if (have_posts()) {
      while (have_posts()) {

        the_post();
        $terms = get_the_terms(get_the_ID(), $taxName);
        ?>
        <div class="downloadPage__wrapper">
            <div class="queryy-breadcrumb">
                <?php include 'partials/breadcrumbs.php'; ?>
            </div>
            <div class="downLoad__container  mainContainer">
                <div>
                    <header class="queryy-page-header">
                        <div class="queryy-page-header__inner">
                            <div class="queryy-page-header__text">
                                <p class="queryy-page-title-en">DOWNLOAD</p>
                            </div>
                        </div>
                    </header>
                    <h2 class="downloadPage__title" data-only-show="sp"><?php the_title(); ?></h2>
                    <section class="left">
                        <h2 class="downloadPage__title" data-only-show="pc"><?php the_title(); ?></h2>
                        <div class="downloadPage__summaryContainer">
                            <div class="downloadPage__summaryBox <?php echo $is_gif_class; ?>">
                            <div class="downloadPage__summaryBox_summary">
                                <?php the_content(); ?>
                            </div>
                            <?php if (!empty($gif_url)): ?>
                                <div class="downloadPage__summaryBox_image">
                                    <picture>
                                        <img src="<?php echo esc_url($gif_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
                                    </picture>
                                </div>
                            
                            <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="right downloadPage__hubspotformArea">
                    <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
                    <script>
                    hbspt.forms.create({
                        region: "na1",
                        portalId: "7977366",
                        formId: "<?php echo $hubspotId; ?>"
                    });
                    </script>
                    <p class="downloadPage__hubspotformArea_policy">送信することで、<a href="<?php echo esc_url(home_url('/policy')) ?>" target="_blank" class="downloadPage__hubspotformArea_policyLink">プライバシーポリシー</a>に同意したものとします。</p>
                </div>
            </div>
        </div>
        </div>
    <?php
      }
    } ?>

<?php get_footer(); ?>
