/**
 * @fileoverview
 * 目次（TOC）開閉の制御。
 * --max-height を実測してCSSアニメーション用の値を更新し、「もっと見る」ボタンを動的に追加します。
 *
 * 前提DOM（例）:
 * - ルート要素（#toc_container など）
 * - クリックハンドラ要素（.toc_title など）
 * - 開閉対象のコンテンツ要素（.toc_list など）
 */
export class TOC {
  constructor(rootElement, handler, content) {
    this.rootElement = rootElement;
    this.handler = handler;
    this.content = content;
    this.updateMaxHeight();

    this.appendButton();
    this.attachEvents();
  }

  /**
   * tocを開く際、max-heightの値が高すぎるとアニメーションの視覚的なdurationが高すぎるため適宜変更する
   */
  updateMaxHeight() {
    this.maxHeight = this.content.scrollHeight;
    this.content.style.setProperty('--max-height', `${this.maxHeight}px`);
  }

  attachEvents() {
    const handlers = [this.button, this.handler];
    handlers.forEach((handler) => {
      handler.addEventListener('click', () => {
        if (this.rootElement.classList.contains('open')) {
          this.rootElement.classList.remove('open');
        } else {
          this.rootElement.classList.add('open');
        }
      });
    });

    window.addEventListener('resize', () => {
      this.updateMaxHeight();
    });
  }

  appendButton() {
    const buttonElement = document.createElement('button');
    buttonElement.classList.add('toc_button');
    buttonElement.textContent = 'もっと見る';

    const arrowElement = document.createElement('div');
    arrowElement.textContent = "\u2228";
    arrowElement.classList.add('toc_button__arrow');

    buttonElement.appendChild(arrowElement);
    this.rootElement.appendChild(buttonElement);
    this.button = buttonElement;
  }
}
