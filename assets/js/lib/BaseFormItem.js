/**
 * @fileoverview
 * フォーム入力1項目分の基底クラス。
 * 必須チェックや形式チェックなどは派生クラスで行い、ここではエラー表示と invalid 状態管理を担います。
 *
 * 前提DOM:
 * - errorElement にエラーテキストを書き込めること
 */
export class BaseFormItem {
  input = null;
  isRequired = false;
  errorElement = null;
  name = '';
  value = '';
  invalid = false;
  constructor() {
    this.input = null;
    this.isRequired = false;
    this.errorElement = null;
    this.value = '';
    this.invalid = false;
  }

  get name() {
    return this.name;
  }

  get value() {
    return this.value;
  }

  get invalid() {
    return this.invalid;
  }

  addMessage(message) {
    this.errorElement.textContent = message;

    this.#updateInvalid(true);
  }

  removeMessage() {
    this.errorElement.textContent = '';

    this.#updateInvalid(false);
  }

  #updateInvalid(state) {
    this.invalid = state;
  }
}
