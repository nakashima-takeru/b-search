/**
 * @fileoverview
 * 検索結果/記事一覧系ページで使うページスクリプト。
 * ベーシックスライダーを初期化します。
 *
 * 依存:
 * - Splide（グローバル）
 */
import { initBasicSlider } from '../modules/slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initBasicSlider();
});
