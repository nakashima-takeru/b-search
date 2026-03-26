/**
 * @fileoverview
 * 右下で追従するCTAの閉じる処理。
 * 閉じるボタン押下でコンテナに is-close を付与します。
 *
 * 前提DOM（例）:
 * - .js-global-nav-cv
 * - .js-global-nav-cv__close
 */
export class GlobalNavCV {
  constructor() {
    this.cvContainer = document.querySelector(".js-global-nav-cv");
    this.closeButton = document.querySelector(".js-global-nav-cv__close");

    if (!this.cvContainer || !this.closeButton) {
      console.warn('GlobalNavCV: Container or button not found. ');
      return;
    }

    this.init();
  }

  init() {
    this.closeButton.addEventListener('click', () => {
      this.cvContainer.classList.add('is-close');
    });
  }
}
