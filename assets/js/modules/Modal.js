/**
 * @fileoverview
 * 汎用モーダルの開閉制御。
 * 現状検索モーダルで使用しています。
 * .modal-btn の data-modal で対象モーダル要素を特定し、クラス切替で表示します。
 *
 * 前提DOM（例）:
 * - .modal-btn（data-modal にモーダルID）
 * - .modal-outer / .modal-inner
 * - .modal-close_btn
 */
export class Modal {
  constructor() {
    this.modalButtons = document.querySelectorAll('.modal-btn');
    this.closeButtons = document.querySelectorAll('.modal-close_btn');
    this.modalOuters = document.querySelectorAll('.modal-outer');
    this.body = document.querySelector('body');

    this.init();
  }

  init() {
    this.setupModalButtons();
    this.setupCloseButtons();
    this.setupModalOuters();
  }

  setupModalButtons() {
    if (!this.modalButtons.length) {
      console.warn('Modal: No modal buttons found');
      return;
    }

    this.modalButtons.forEach(button => {
      button.addEventListener('click', () => {
        const modalAttribute = button.getAttribute('data-modal');
        if (!modalAttribute) {
          console.warn('Modal: data-modal attribute not found on button');
          return;
        }

        const modalShow = document.getElementById(modalAttribute);
        if (!modalShow) {
          console.warn(`Modal: Modal with id "${modalAttribute}" not found`);
          return;
        }

        modalShow.classList.add('is-show');
        this.body.classList.add('is-modalOpen');
      });
    });
  }

  setupCloseButtons() {
    if (!this.closeButtons.length) {
      console.warn('Modal: No close buttons found');
      return;
    }

    this.closeButtons.forEach(button => {
      button.addEventListener('click', () => {
        const modal = button.closest('.modal-outer');
        if (!modal) {
          console.warn('Modal: Could not find parent modal-outer element');
          return;
        }

        modal.classList.remove('is-show');
        this.body.classList.remove('is-modalOpen');
      });
    });
  }

  setupModalOuters() {
    if (!this.modalOuters.length) {
      console.warn('Modal: No modal-outer elements found');
      return;
    }

    this.modalOuters.forEach(outer => {
      outer.addEventListener('click', (event) => {
        if (event.target.closest('.modal-inner') === null) {
          outer.classList.remove('is-show');
          this.body.classList.remove('is-modalOpen');
        }
      });
    });
  }
}
