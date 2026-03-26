/**
 * @fileoverview
 * ホーム用のページスクリプト。
 * Splide系のスライダーを初期化します。
 *
 * 読み込み:
 * - theme/functions.php の is_front_page() 分岐から読み込まれます。
 *
 * 依存:
 * - Splide（グローバル）
 */
import {
  initPickupSlider,
  initUpdateSlider,
  initBasicSlider,
} from '../modules/slider.js';

document.addEventListener('DOMContentLoaded', () => {
  initPickupSlider();
  initUpdateSlider();
  initBasicSlider();
});
