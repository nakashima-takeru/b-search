/**
 * @fileoverview
 * 全記事一覧（home.php）用のページスクリプト。
 * Splide系のスライダーを初期化します。
 *
 * 読み込み:
 * - theme/functions.php の is_home() 分岐から読み込まれます。
 *
 * 依存:
 * - Splide（グローバル）
 */
import { initBasicSlider } from '../modules/slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initBasicSlider();
});
