/**
 * @fileoverview
 * フォーム送信の共通基盤クラス。
 * - BaseFormItem 群を登録して一括バリデーション
 * - HubSpot送信（sendHubspot）を呼び出し、成功時にリダイレクト
 *
 * 依存:
 * - sendHubspot（HubSpot API送信。内部で axios を利用）
 * - SITE_DATA（サイトURLなどの定数）
 */
import { SITE_DATA } from '../../data/info.js';
import { sendHubspot } from '../services/hubspot.js';

export class BaseForm {
  #isSending = false;
  #items = {};
  #invalid = false;
  #portalID = null;
  #formID = null;
  constructor({ portalID, formID }) {
    this.#portalID = portalID;
    this.#formID = formID;
  }

  get items() {
    return this.#items;
  }

  get invalid() {
    return this.#invalid;
  }

  get isSending() {
    return this.#isSending;
  }

  checkInvalid() {
    if (this.#isSending) return;

    // 全部のformItemをチェック
    this.#validateAll();

    return this.#invalid;
  }

  async handleFormSubmission(fields, redirectSlug) {

    this.#isSending = true;

    try {
      await sendHubspot(
        this.#portalID,
        this.#formID,
        fields,
        { pageUri: location.href, pageName: document.title }
      );
      window.location.href = `${SITE_DATA.BASE_URL}/${redirectSlug}`;
    } catch (e) {
      console.log(e);
    }
  }

  #validateAll() {
    Object.values(this.#items).forEach((item) => item.validate());
    this.#updateInvalid();
  }

  #updateInvalid() {
    this.#invalid = Object.values(this.#items).some((item) => item.invalid);
  }

  addItem(name, item) {
    this.#items[name] = item;
  }
}
