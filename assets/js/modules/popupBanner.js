/**
 * @fileoverview
 * スクロール量に応じて表示されるポップアップバナー制御。
 * 一定スクロール後に active を付与し、閉じると disabled を付与して監視を停止します。
 *
 * 前提DOM（例）:
 * - .js-popup-banner
 * - .js-popup-banner-closure
 */
export class PopupBanner {
  isClosed = false;
  constructor(element) {
    this.element = element;

    window.addEventListener('scroll', this.handleScroll);

    const closure = element.querySelector('.js-popup-banner-closure');

    if (!closure) {
      throw new Error('閉じるボタンがありません。');
    }

    closure.addEventListener('click', () => {
      this.element.classList.add('disabled');
      this.isClosed = true;

      window.removeEventListener('scroll', this.handleScroll);
    });
  }

  handleScroll = () => {
    const isActive = this.element.classList.contains('active');

    if (!isActive && window.scrollY > window.innerHeight * 2) {
      this.element.classList.add('active');
    } else if (isActive && window.scrollY < window.innerHeight * 2) {
      this.element.classList.remove('active');
    }
  };
}
