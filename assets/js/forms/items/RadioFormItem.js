/**
 * @fileoverview
 * ラジオボタン群用のフォームItem。
 * required の必須チェックを行い、未選択の場合にエラーを表示します。
 *
 * 前提DOM（例）:
 * - element 配下に input[type="radio"]
 * - element の親に .js-form-item-parent
 * - 親内に .errorText（エラー表示）
 */
import { BaseFormItem } from '../../lib/BaseFormItem.js';

export class RadioFormItem extends BaseFormItem {
  constructor(element) {
    super();
    this.type = 'radio';
    this.radioButtons = Array.from(
      element.querySelectorAll('input[type="radio"]')
    );
    this.isRequired = this.radioButtons.some((input) =>
      input.hasAttribute('required')
    );
    this.errorElement = element
      .closest('.js-form-item-parent')
      .querySelector('.errorText');

    this.radioButtons.forEach((input) => {
      input.addEventListener('change', () => this.validate());
    });
  }
  validate() {
    const checkedInput = this.radioButtons.find((element) => element.checked);
    this.value = checkedInput ? checkedInput.value : '';

    if (this.isRequired && !this.value) {
      this.addMessage('必須入力です。');
    } else {
      this.removeMessage();
    }
  }
}
