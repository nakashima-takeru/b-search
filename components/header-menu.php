<?php
$getPageDir = explode('/', $_SERVER['REQUEST_URI']);
$pageDir = $getPageDir[1];
// トップページ条件取得用
$getHomeDir = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
?>
<header class="global-header js-global-header <?php if ($pageDir === 'blog') {
                                                      echo ' global-header_queryy';
                                                    } ?>">
  <div class="global-header__container">
    <div class="global-header__inner">
      <div class="global-header__logo">
        <?php if (empty($getHomeDir[0])): ?>
          <h1>
            <a href="<?php echo esc_url(home_url()) ?>" class="global-header-logo__link js-global-header-logo-link">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/header-logo.png" alt="採用スマートナビ" width="260" height="32" loading="eager">
            </a>
          </h1>
        <?php else: ?>
          <p>
            <a href="<?php echo esc_url(home_url()) ?>" class="global-header-logo__link js-global-header-logo-link">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/header-logo.png" alt="採用スマートナビ" width="260" height="32" loading="eager">
            </a>
          </p>
        <?php endif; ?>
      </div>
      <div>
        <nav class="global-header__nav">
          <ul class="global-header__list">
            <li class="global-header__item">
              <div data-id="header-media" class="global-header__link js-global-header-link">
                カテゴリ一覧
                <span class="global-header__link-arrow">
                  <svg width="9" height="6" viewBox="0 0 9 6" fill="none" class="svg-arrow-bottom">
                    <path d="M0.353516 0.353546L4.35352 4.35355L8.35352 0.353546" stroke="currentColor"/>
                  </svg>
                  <svg width="9" height="6" viewBox="0 0 9 6" fill="none" class="svg-arrow-bottom">
                    <path d="M0.353516 0.353546L4.35352 4.35355L8.35352 0.353546" stroke="currentColor"/>
                  </svg>
                </span>
              </div>
            </li>

            <li class="global-header__item">
              <div data-id="header-service" class="global-header__link js-global-header-link">
                サービス一覧
                <span class="global-header__link-arrow">
                  <svg width="9" height="6" viewBox="0 0 9 6" fill="none" class="svg-arrow-bottom">
                    <path d="M0.353516 0.353546L4.35352 4.35355L8.35352 0.353546" stroke="currentColor"/>
                  </svg>
                  <svg width="9" height="6" viewBox="0 0 9 6" fill="none" class="svg-arrow-bottom">
                    <path d="M0.353516 0.353546L4.35352 4.35355L8.35352 0.353546" stroke="currentColor"/>
                  </svg>
                </span>
              </div>
            </li>

            <li class="global-header__item">
              <a href="" target="_blank" class="global-header__link js-global-header-link">
                企業情報
                <svg class="svg-blank" astro-icon="blank">
                  <use xlink:href="#astroicon:blank"></use>
                </svg>
              </a>
            </li>
          </ul>
          <ul class="global-header__cta">
            <li class="global-header__item">
              <a href="https://timerex.net/s/yos_94d9/b6dba866/" class="global-header__link-button global-header__link-button--orange js-global-header-link" target="_blank">
                無料オンライン相談予約
              </a>
            </li>
             <li class="global-header__item">
              <a href="<?php echo esc_url(home_url('/contact')) ?>" class="global-header__link-button global-header__link-button--yellow js-global-header-link">
                採用に関する問い合わせ
              </a>
            </li>
          </ul>
          <div class="global-header__item">
            <button class="global-header__search-button modal-btn" data-modal="modal-search">
              <span class="img">
                <svg fill="none" height="33" viewBox="0 0 33 33" width="33">
                  <mask id="a" height="33" maskUnits="userSpaceOnUse" width="33" x="0" y="0"><path d="m0 0h32.7273v32.7273h-32.7273z" fill="#d9d9d9"/></mask><g mask="url(#a)"><path d="m26.6487 28.0595-8.5647-8.5647c-.6818.5629-1.4659 1.0035-2.3523 1.3216-.8864.3182-1.8033.4773-2.7509.4773-2.3306 0-4.30317-.807-5.91753-2.4209-1.61436-1.614-2.42155-3.586-2.42155-5.9161s.80698-4.30279 2.42094-5.91818c1.61395-1.61536 3.58594-2.42304 5.91604-2.42304s4.3028.80718 5.9182 2.42155c1.6154 1.61436 2.4231 3.58687 2.4231 5.91757 0 .9738-.1635 1.9038-.4904 2.7902s-.7631 1.6573-1.3086 2.3129l8.5647 8.5647zm-13.6679-8.8112c1.757 0 3.2452-.6097 4.4646-1.8291 1.2195-1.2194 1.8292-2.7076 1.8292-4.4646s-.6097-3.24521-1.8292-4.46462c-1.2194-1.21941-2.7076-1.82912-4.4646-1.82912s-3.24517.60971-4.46458 1.82912c-1.21938 1.21941-1.82908 2.70762-1.82908 4.46462s.6097 3.2452 1.82908 4.4646c1.21941 1.2194 2.70758 1.8291 4.46458 1.8291z" fill="#fff"/></g>
                </svg>
              </span>
            </button>
          </div>
        </nav>
        <div class="global-header__sp-nav">
          <button class="global-header__search-button modal-btn" data-modal="modal-search">
            <span class="img">
              <svg fill="none" height="33" viewBox="0 0 33 33" width="33">
                <mask id="a" height="33" maskUnits="userSpaceOnUse" width="33" x="0" y="0"><path d="m0 0h32.7273v32.7273h-32.7273z" fill="#d9d9d9"/></mask><g mask="url(#a)"><path d="m26.6487 28.0595-8.5647-8.5647c-.6818.5629-1.4659 1.0035-2.3523 1.3216-.8864.3182-1.8033.4773-2.7509.4773-2.3306 0-4.30317-.807-5.91753-2.4209-1.61436-1.614-2.42155-3.586-2.42155-5.9161s.80698-4.30279 2.42094-5.91818c1.61395-1.61536 3.58594-2.42304 5.91604-2.42304s4.3028.80718 5.9182 2.42155c1.6154 1.61436 2.4231 3.58687 2.4231 5.91757 0 .9738-.1635 1.9038-.4904 2.7902s-.7631 1.6573-1.3086 2.3129l8.5647 8.5647zm-13.6679-8.8112c1.757 0 3.2452-.6097 4.4646-1.8291 1.2195-1.2194 1.8292-2.7076 1.8292-4.4646s-.6097-3.24521-1.8292-4.46462c-1.2194-1.21941-2.7076-1.82912-4.4646-1.82912s-3.24517.60971-4.46458 1.82912c-1.21938 1.21941-1.82908 2.70762-1.82908 4.46462s.6097 3.2452 1.82908 4.4646c1.21941 1.2194 2.70758 1.8291 4.46458 1.8291z" fill="#fff"/></g>
              </svg>
            </span>
          </button>
          <button class="global-hamburger-menu-btn js-global-hamburger-menu-btn">
            <span class="global-hamburger-menu-btn__line"></span>
            <span class="global-hamburger-menu-btn__line"></span>
          </button>
        </div>
      </div>
      <div id="header-media" class="global-header-contents js-global-header-contents">
        <div class="global-header-contents__inner">
          <div class="global-header-contents__title-wrapper">
            <div class="global-header-contents__title hover-line-trigger">
              <div class="global-header-contents__title-link">カテゴリ一覧</div>
            </div>
          </div>
          <ul class="global-header-contents__list">
            <li class="global-header-contents__item hover-line-trigger">
              <a href="<?php echo esc_url(home_url('/recruitmentservice')) ?>"
                class="global-header-contents__link hover-line-white">採用サービス</a>
            </li>
            <li class="global-header-contents__item hover-line-trigger">
              <a href="<?php echo esc_url(home_url('/recruitment-problem')) ?>"
                class="global-header-contents__link hover-line-white">採用課題</a>
            </li>
            <li class="global-header-contents__item hover-line-trigger">
              <a href="<?php echo esc_url(home_url('/recruitment-strategy')) ?>"
                class="global-header-contents__link hover-line-white">採用戦略</a>
            </li>
            <li class="global-header-contents__item hover-line-trigger">
              <a href="<?php echo esc_url(home_url('/')) ?>"
                class="global-header-contents__link hover-line-white">採用総研（bサーチ）</a>
            </li>
          </ul>
        </div>
      </div>
      <div id="header-service" class="global-header-contents js-global-header-contents">
        <div class="global-header-contents__inner">
          <div class="global-header-contents__title-wrapper">
            <div class="global-header-contents__title hover-line-trigger">
              <div class="global-header-contents__title-link">サービス一覧</div>
            </div>
          </div>
          <ul class="global-header-contents__list">
            <li class="global-header-contents__item hover-line-trigger">
              <a href="" class="global-header-contents__link hover-line-white">サービス1</a>
            </li>
            <li class="global-header-contents__item hover-line-trigger">
              <a href="" class="global-header-contents__link hover-line-white">サービス2</a>
            </li>
            <li class="global-header-contents__item hover-line-trigger">
              <a href="" class="global-header-contents__link hover-line-white">サービス3</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>
<div class="global-hamburger">
  <div class="global-hamburger-menu">
    <div class="global-hamburger-menu__wrapper">
      <div class="global-hamburger-menu__upper">
        <div class="global-hamburger-menu__logo-area">
          <p class="global-hamburger-menu__logo">
            <a href="<?php echo esc_url(home_url()) ?>" class="global-hamburger-menu__logo-link">
              <svg width="200" height="30" viewBox="0 0 200 30" fill="none">
                <path d="M15.5664 21.2695C15.5664 20.8268 15.5013 20.4297 15.3711 20.0781C15.2409 19.7135 15 19.375 14.6484 19.0625C14.2969 18.75 13.7891 18.4375 13.125 18.125C12.474 17.7995 11.6146 17.4609 10.5469 17.1094C9.29688 16.6927 8.09245 16.224 6.93359 15.7031C5.77474 15.1693 4.73958 14.5508 3.82812 13.8477C2.91667 13.1315 2.19401 12.2982 1.66016 11.3477C1.1263 10.3841 0.859375 9.26432 0.859375 7.98828C0.859375 6.76432 1.13281 5.66406 1.67969 4.6875C2.22656 3.69792 2.98828 2.85807 3.96484 2.16797C4.95443 1.46484 6.11328 0.93099 7.44141 0.566406C8.76953 0.188802 10.2214 0 11.7969 0C13.8802 0 15.7161 0.364583 17.3047 1.09375C18.9062 1.8099 20.1562 2.83203 21.0547 4.16016C21.9661 5.47526 22.4219 7.03125 22.4219 8.82812H15.6055C15.6055 8.11198 15.4557 7.48047 15.1562 6.93359C14.8698 6.38672 14.4336 5.95703 13.8477 5.64453C13.2617 5.33203 12.526 5.17578 11.6406 5.17578C10.7812 5.17578 10.0586 5.30599 9.47266 5.56641C8.88672 5.82682 8.44401 6.17839 8.14453 6.62109C7.84505 7.05078 7.69531 7.52604 7.69531 8.04688C7.69531 8.47656 7.8125 8.86719 8.04688 9.21875C8.29427 9.55729 8.63932 9.8763 9.08203 10.1758C9.53776 10.4753 10.0846 10.7617 10.7227 11.0352C11.3737 11.3086 12.1029 11.5755 12.9102 11.8359C14.4206 12.3177 15.7617 12.8581 16.9336 13.457C18.1185 14.043 19.1146 14.7135 19.9219 15.4688C20.7422 16.2109 21.3607 17.0573 21.7773 18.0078C22.207 18.9583 22.4219 20.0326 22.4219 21.2305C22.4219 22.5065 22.1745 23.6393 21.6797 24.6289C21.1849 25.6185 20.4753 26.4583 19.5508 27.1484C18.6263 27.8255 17.5195 28.3398 16.2305 28.6914C14.9414 29.043 13.5026 29.2188 11.9141 29.2188C10.4557 29.2188 9.01693 29.0365 7.59766 28.6719C6.19141 28.2943 4.91536 27.7214 3.76953 26.9531C2.6237 26.1719 1.70573 25.1758 1.01562 23.9648C0.338542 22.7409 0 21.2891 0 19.6094H6.875C6.875 20.4427 6.98568 21.1458 7.20703 21.7188C7.42839 22.2917 7.75391 22.7539 8.18359 23.1055C8.61328 23.444 9.14062 23.6914 9.76562 23.8477C10.3906 23.9909 11.1068 24.0625 11.9141 24.0625C12.7865 24.0625 13.4896 23.9388 14.0234 23.6914C14.5573 23.431 14.9479 23.0924 15.1953 22.6758C15.4427 22.2461 15.5664 21.7773 15.5664 21.2695ZM34.0422 0.390625V28.8281H27.2062V0.390625H34.0422ZM52.85 0.390625V28.8281H45.9945V0.390625H52.85ZM61.4047 0.390625V5.68359H37.6352V0.390625H61.4047ZM83.8852 23.5547V28.8281H68.7289V23.5547H83.8852ZM71.1703 0.390625V28.8281H64.3148V0.390625H71.1703ZM81.932 11.6797V16.7773H68.7289V11.6797H81.932ZM83.9437 0.390625V5.68359H68.7289V0.390625H83.9437ZM109.256 0.390625V28.8281H102.401V0.390625H109.256ZM117.811 0.390625V5.68359H94.0414V0.390625H117.811ZM128.006 0.390625V28.8281H121.17V0.390625H128.006ZM146.814 0.390625V28.8281H139.959V0.390625H146.814ZM155.369 0.390625V5.68359H131.599V0.390625H155.369ZM177.068 23.5547V28.8281H162.693V23.5547H177.068ZM165.134 0.390625V28.8281H158.279V0.390625H165.134ZM199.529 23.5547V28.8281H184.373V23.5547H199.529ZM186.814 0.390625V28.8281H179.959V0.390625H186.814ZM197.576 11.6797V16.7773H184.373V11.6797H197.576ZM199.587 0.390625V5.68359H184.373V0.390625H199.587Z" fill="currentColor"/>
              </svg>
            </a>
          </p>
          <button class="global-hamburger-menu-btn js-global-hamburger-menu-btn is-close">
            <span class="global-hamburger-menu-btn__line"></span>
            <span class="global-hamburger-menu-btn__line"></span>
          </button>
        </div>
        <nav class="global-hamburger-menu__nav">
          <ul class="global-hamburger-menu__list">
            <li class="global-hamburger-menu__item">
              <button type="button" class="global-hamburger-menu__link js-global-hamburger-dropdown-toggle"
                aria-expanded="false" aria-controls="hamburger-submenu-category">
                カテゴリ一覧
                <span class="global-hamburger-menu__toggle-icon" aria-hidden="true">
                  <span class="global-hamburger-menu__toggle-icon-line is-horizontal"></span>
                  <span class="global-hamburger-menu__toggle-icon-line is-vertical"></span>
                </span>
              </button>
              <div id="hamburger-submenu-category" class="global-hamburger-menu__submenu" hidden>
                <ul class="global-hamburger-menu__submenu-list">
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="<?php echo esc_url(home_url('/webad')); ?>" class="global-hamburger-menu__submenu-link">
                      採用サービス
                    </a>
                  </li>
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="<?php echo esc_url(home_url('/seo')); ?>" class="global-hamburger-menu__submenu-link">
                      採用課題
                    </a>
                  </li>
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="<?php echo esc_url(home_url('/news')); ?>" class="global-hamburger-menu__submenu-link">
                      採用戦略
                    </a>
                  </li>
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="<?php echo esc_url(home_url('/recruit')); ?>" class="global-hamburger-menu__submenu-link">
                      採用総研（bサーチ）
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="global-hamburger-menu__item">
              <button type="button" class="global-hamburger-menu__link js-global-hamburger-dropdown-toggle"
                aria-expanded="false" aria-controls="hamburger-submenu-service">
                サービス一覧
                <span class="global-hamburger-menu__toggle-icon" aria-hidden="true">
                  <span class="global-hamburger-menu__toggle-icon-line is-horizontal"></span>
                  <span class="global-hamburger-menu__toggle-icon-line is-vertical"></span>
                </span>
              </button>
              <div id="hamburger-submenu-service" class="global-hamburger-menu__submenu" hidden>
                <ul class="global-hamburger-menu__submenu-list">
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="" class="global-hamburger-menu__submenu-link">
                      サービス1
                    </a>
                  </li>
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="" class="global-hamburger-menu__submenu-link">
                      サービス2
                    </a>
                  </li>
                  <li class="global-hamburger-menu__submenu-item">
                    <a href="" class="global-hamburger-menu__submenu-link">
                      サービス3
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="global-hamburger-menu__item">
              <a href="" target="_blank" class="global-hamburger-menu__link">
                企業情報
                <svg class="svg-blank" astro-icon="blank">
                  <use xlink:href="#astroicon:blank"></use>
                </svg>
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="global-hamburger-menu__btn-area">
        <div class="global-hamburger-menu__btn">
          <div class="buttonItem" data-color="orange">
            <a href="<?php echo esc_url(home_url('/download-pdf')); ?>" class="buttonItem__link">
              </span>
              オンライン相談予約
            </a>
          </div>
        </div>
        <div class="global-hamburger-menu__btn">
          <div class="buttonItem" data-color="yellow">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="buttonItem__link">
              メール問合せ
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
