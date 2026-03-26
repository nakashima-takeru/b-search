/**
 * @fileoverview
 * 記事途中で表示するインタースティシャルバナー制御。
 * スクロール位置や記事内h2の位置に応じて open を付与し、同日中はlocalStorageで再表示を抑制します。
 *
 * 前提DOM（例）:
 * - .js-interstitial-banner
 * - .js-interstitial-banner-closure
 * - .js-queryy-entry（本文領域。h2 検出に利用）
 */
export class InterstitialBanner {
  #STORAGE_KEY = 'interstitialBannerLastView';
  constructor(element) {
    this.banner = element;
    this.today = new Date().toISOString().slice(0, 10);

    if (localStorage.getItem(this.#STORAGE_KEY) === this.today) return;

    const closureElements = element.querySelectorAll(
      '.js-interstitial-banner-closure'
    );

    this.h2Elements = document
      .querySelector('.js-queryy-entry')
      .querySelectorAll('h2');

    if (!closureElements) {
      throw new Error('閉じるボタンがありません。');
    }

    this.handleScroll();
    window.addEventListener('scroll', this.handleScroll);

    closureElements.forEach((element) => {
      element.addEventListener('click', () => {
        this.banner.classList.remove('open');

        window.removeEventListener('scroll', this.handleScroll);
      });
    });
  }

  handleScroll = () => {
    const pageHeight = document.documentElement.scrollHeight;
    const windowHeight = window.innerHeight;
    const scrollPosition = window.scrollY;

    // h2要素が4つ以上存在する記事の場合
    if (this.h2Elements && this.h2Elements.length > 3) {
      const baseHeight = this.h2Elements[2].getBoundingClientRect().y;
      if (scrollPosition > baseHeight) {
        this.open();
      }
    } else if (scrollPosition > pageHeight / 2 - windowHeight) {
      this.open();
    }
  };

  open() {
    this.banner.classList.add('open');
    localStorage.setItem(this.#STORAGE_KEY, this.today);
  }
}
