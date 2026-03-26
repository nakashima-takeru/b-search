/**
 * @fileoverview
 * 著者・監修者一覧用のページスクリプト。
 * Update/Basic スライダーを初期化します。
 *
 * 依存:
 * - Splide（グローバル）
 */
import { initUpdateSlider, initBasicSlider } from '../modules/slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initUpdateSlider();
  initBasicSlider();
});
