/**
 * @fileoverview
 * グローバルヘッダーのメガメニュー制御。
 * ヘッダーリンクのhoverで対象コンテンツをGSAPで開閉し、オーバーレイと連動します。
 *
 * 前提DOM（例）:
 * - .js-global-header-link（data-id に対応するコンテンツIDを持つ）
 * - .js-global-header-overlay
 * - .js-global-header-logo-link
 * - .js-global-header-contents
 *
 * 依存:
 * - gsap（グローバル）
 */
export class MegaMenu {
  constructor() {
    this.headerLinks = document.querySelectorAll('.js-global-header-link');
    this.overlay = document.querySelector('.js-global-header-overlay');
    this.logoLink = document.querySelector('.js-global-header-logo-link');
    this.headerContents = document.querySelectorAll('.js-global-header-contents');

    if (!this.overlay) {
      console.warn('MegaMenu: Overlay element not found');
      return;
    }

    if (!this.logoLink) {
      console.warn('MegaMenu: Logo link element not found');
      return;
    }

    this.init();
  }

  init() {
    this.setInitialState();
    this.bindEvents();
  }

  setInitialState() {
    if (!this.headerContents.length) {
      console.warn('MegaMenu: No header contents found');
      return;
    }

    this.headerContents.forEach(content => {
      gsap.set(content, {
        opacity: 0,
        height: 0,
        display: 'none'
      });
    });
  }

  bindEvents() {
    if (!this.headerLinks.length) {
      console.warn('MegaMenu: No header links found');
      return;
    }

    this.headerLinks.forEach((link) => {
      link.addEventListener('mouseenter', () => {
        this.hideAllContents(); // 全ての要素を隠す
        link.classList.add('is-hover');

        const targetId = link.getAttribute('data-id');
        if (!targetId) {
          console.warn('MegaMenu: data-id attribute not found on header link');
          return;
        }

        const targetContent = document.getElementById(targetId);
        if (!targetContent) {
          console.warn(`MegaMenu: Target content with id "${targetId}" not found`);
          return;
        }

        this.overlay.classList.add('is-hover');

        // 対象のコンテンツを表示
        gsap.to(targetContent, {
          opacity: 1,
          height: '7vw',
          display: 'flex',
          duration: 0.4,
          ease: "cubic-bezier(0.26, 0.16, 0.1, 1)",
        });
      });

      link.addEventListener('mouseleave', () => {
        if (link.dataset.id) return;

        link.classList.remove('is-hover');
        this.overlay.classList.remove('is-hover');
      });
    });

    this.overlay.addEventListener('mouseenter', () => {
      this.hideAllContents();
    });

    this.logoLink.addEventListener('mouseenter', () => {
      this.hideAllContents();
    });
  }

  hideAllContents() {
    if (!this.headerLinks.length) {
      console.warn('MegaMenu: No header links found');
      return;
    }

    this.headerLinks.forEach(link => {
      link.classList.remove('is-hover');
    });

    this.overlay.classList.remove('is-hover');

    if (!this.headerContents.length) {
      console.warn('MegaMenu: No header contents found');
      return;
    }

    this.headerContents.forEach(content => {
      gsap.to(content, {
        opacity: 0,
        height: 0,
        duration: 0.4,
        ease: "cubic-bezier(0.26, 0.16, 0.1, 1)",
        onComplete: () => {
          content.style.display = 'none';
        }
      });
    });
  }
}
