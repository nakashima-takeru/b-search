<?php
$args = wp_parse_args($args, [
  'downloadBanner' => null,
]);

$image = $args['downloadBanner']['download_banner_image'] ?? null;
$image_url = $image['url'] ?? '';
$image_alt = $image['alt'] ?? '';
$image_width = $image['width'] ?? '';
$image_height = $image['height'] ?? '';
?>

<?php if (
  $args['downloadBanner'] &&
  $args['downloadBanner']['download_banner_title'] &&
  $args['downloadBanner']['download_banner_value'] &&
  $args['downloadBanner']['download_banner_form_id']
): ?>
  <div class="download-banner js-download-banner-form">
    <h2 class="download-banner__title"><?php echo $args['downloadBanner'][
      'download_banner_title'
    ]; ?></h2>
    <div class="download-banner__content">
      <p class="download-banner__desc"><?php echo $args['downloadBanner'][
        'download_banner_description'
      ]; ?></p>
      <?php if ($image_url): ?>
        <div class="download-banner__image">
          <img
            src="<?php echo $image_url; ?>"
            alt="<?php echo $image_alt; ?>"
            width="<?php echo $image_width; ?>"
            height="<?php echo $image_height; ?>"
          >
        </div>
      <?php endif; ?>
      <form action="" name="download-banner" class="download-banner__form">
        <ul class="download-banner__form-list">
          <li class="download-banner-form-item js-form-item-parent">
            <label for="company_download-banner-form">会社名</label>
            <input type="text" id="company_download-banner-form" placeholder="株式会社ニュートラルワークス" class="js-download-banner-form__company" required />
            <p class="errorText"></p>
          </li>
          <li class="download-banner-form-item js-form-item-parent">
            <label for="lastname_download-banner-form">担当者名</label>
            <input type="text" id="lastname_download-banner-form" placeholder="ニュートラル太郎" data-message="" class="js-download-banner-form__lastname" required />
            <p class="errorText"></p>
          </li>
          <li class="download-banner-form-item js-form-item-parent">
            <label for="email_download-banner-form">メールアドレス</label>
            <input type="text" id="email_download-banner-form" placeholder="example@example.com" data-message="" class="js-download-banner-form__email" required />
            <p class="errorText"></p>
          </li>
          <li class="download-banner-form-item js-form-item-parent">
            <label for="phone_download-banner-form">電話番号</label>
            <input type="text" id="phone_download-banner-form" placeholder="0466-30-5070" data-message="" class="js-download-banner-form__phone" required />
            <p class="errorText"></p>
          </li>
          <li class="download-banner-form-item js-form-item-parent">
            <label for="price_pulldown_download-banner-form">想定のご予算</label>
            <select name="price_pulldown" id="price_pulldown_download-banner-form" class="js-download-banner-form__price_pulldown" required>
              <option value="" disabled selected>選択してください</option>
              <option value="～10万円">～10万円</option>
              <option value="11万円～100万円">11万円～100万円</option>
              <option value="101万円～">101万円～</option>
            </select>
            <p class="errorText"></p>
          </li>
        </ul>

        <button class="download-banner-button js-download-banner-form__submit">
          <div class="download-banner-button__icon">
            <svg width="15" height="13" viewBox="0 0 15 13" fill="none">
              <path d="M1 3.5V12.5H14V3.5" stroke="currentColor"/>
              <path d="M7.5 0V8" stroke="currentColor"/>
              <path d="M5 5.5L7.5 8.5L10 5.5" stroke="currentColor"/>
            </svg>
          </div>
          <span class="download-banner-button__text">資料ダウンロード</span>
        </button>
      </form>
    </div>
  </div>
<?php endif; ?>
