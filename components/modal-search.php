<div id="modal-search" class="modal-search modal-outer">
  <div class="modal-inner">
    <div class="modal-header">
      <div class="modal-close"><span class="modal-close_btn"></span></div>
    </div>
    <div class="modal-container">
      <form action="<?php echo esc_url(home_url('/articles/search')); ?>" class="modal-form" method="get">
        <input type="hidden" name="search_type" value="blog">
        <div class="modal-list">
          <div class="modal-list__item">
            <p class="modal-list__itemTitle">キーワードから記事を検索</p>
            <input class="modal-list__itemKeyword" type="text" name="s" placeholder="検索キーワードを入力">
          </div>
          <div class="modal-list__item">
            <p class="modal-list__itemTitle">カテゴリから記事を検索</p>
            <div class="modal-list__itemSelect">
              <?php
              $args = [
                // 初期値のプレースホルダー
                'show_option_none' => 'カテゴリを選択',
              ];
              // カテゴリーのドロップダウン
              wp_dropdown_categories($args);
              ?>
            </div>
          </div>
        </div>
        <div class="entries-section__button">
          <div class="buttonItem" data-color="blue">
            <button type="submit" class="buttonItem__link modal-search__button">
              検索する
            </button>
          </div>
        </div>
      </form>
      <div class="queryy-lower-tag-list">
        <?php get_template_part('components/list', 'tag'); ?>
      </div>
    </div>
  </div>
</div>
