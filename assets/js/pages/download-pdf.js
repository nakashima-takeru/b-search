/**
 * @fileoverview
 * download-pdf カスタム投稿（単体）用のページスクリプト。
 * Glideを初期化してカルーセルをマウントします。
 *
 * 依存:
 * - Glide（グローバル。glide.min.js が先に読み込まれている想定）
 */
const glide = new Glide('.glide', {
  type: 'carousel',
  focusAt: 'center',
  perView: 1.2,
  gap: 20,
  animationDuration: 1300,

  breakpoints: {
    765: {
      gap: 10,
    },
  },
});
glide.mount();
