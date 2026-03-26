/**
 * @fileoverview
 * 著者詳細ページ用のページスクリプト。
 * Update/Basic/Writer の各スライダーを初期化します。
 *
 * 依存:
 * - Splide（グローバル）
 */
import {
  initUpdateSlider,
  initBasicSlider,
  initWriterSlider,
} from '../modules/slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initUpdateSlider();
  initBasicSlider();
  initWriterSlider();
});
