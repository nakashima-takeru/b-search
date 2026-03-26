/**
 * @fileoverview
 * 全ページ共通のJSエントリポイント。
 * DOMContentLoaded でグローバルUI（メガメニュー/ドロワー/モーダル/CV導線）を初期化します。
 *
 * 依存:
 * - gsap（functions.php でグローバルに読み込まれる想定）
 *
 * 読み込み:
 * - theme/functions.php の wp_enqueue_scripts から app として読み込まれます。
 */
import { MegaMenu } from "./modules/MegaMenu.js";
import { DrawerMenu } from "./modules/DrawerMenu.js";
import { Modal } from './modules/Modal.js';
import { GlobalNavCV } from './modules/GlobalNavCV.js';

document.addEventListener('DOMContentLoaded', () => {
  new MegaMenu();
  new DrawerMenu();
  new Modal();
  new GlobalNavCV();
});
