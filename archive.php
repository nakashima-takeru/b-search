<?php
get_header(); ?>

<main class="queryy-main queryy-lower-page">
  <div class="stack60 sp-stack50">
    <div class="queryy-breadcrumb">
      <?php include 'partials/breadcrumbs.php'; ?>
    </div>
    <div>
      <div class="stack80">
        <div class="stack50">
          <header class="queryy-page-header">
            <div class="queryy-page-header__inner mainContainer">
              <div class="queryy-page-header__text">
                <p class="queryy-page-title-en">Articles</p>
                <h1 class="queryy-page-title-ja"><em>全て</em>の記事一覧</h1>
                <div>
                  <p class="queryy-page-desc">
                    WEB制作に関する記事の一覧です。話題の最新技術やデザイン・テクニックのご紹介など、<br />
                    WEB制作に関するお役立ち情報が満載！
                  </p>
                </div>
              </div>
            </div>
          </header>
          <div class="mainContainer">
            <div class="border-overflow-area">
              <?php get_template_part('components/list', 'category'); ?>
            </div>
          </div>
        </div>
        <div class="stack100 mainContainer queryy-archive-list">
          <?php get_template_part('components/grid-entries', null, [
            'query' => null,
          ]); ?>

          <?php wp_pagenavi(); ?>
        </div>
      </div>

      <section class="download-pickup">
        <div class="mainContainer">
          <header class="section-titleArea">
            <div class="section-titleArea__en">Download</div>
            <h2 class="section-titleArea__jp">お役立ち資料ダウンロード</h2>
          </header>
          <?php if (have_rows('download_pickup', 'option')): ?>
            <div class="download-pickup__list">
              <?php while (have_rows('download_pickup', 'option')):

                the_row();
                $post_pickup = get_sub_field('download_pickup_item');
                $post_pickupID = $post_pickup->ID;
                ?>
                <?php get_template_part('components/card', 'download', [
                  'id' => $post_pickupID,
                ]); ?>
              <?php
              endwhile; ?>
              </div>
            <?php endif; ?>
        </div>
      </section>

      <!-- Ranking-->
      <?php get_template_part('components/section', 'ranking'); ?>

      <div class="stack200 sp-stack150">
        <div class="recommend-section-wrapper">
          <?php get_template_part('components/section', 'recommend'); ?>
        </div>
        <div class="queryy-lower-tag-list">
          <?php get_template_part('components/list', 'tag'); ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php get_footer();
