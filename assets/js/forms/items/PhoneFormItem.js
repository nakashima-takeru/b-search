/**
 * @fileoverview
 * 電話番号入力用のフォームItem。
 * required の必須チェックと、簡易的な電話番号形式チェック（ハイフン任意）を行います。
 *
 * 前提DOM（例）:
 * - 入力要素の親に .js-form-item-parent
 * - 親内に .errorText（エラー表示）
 */
import { BaseFormItem } from '../../lib/BaseFormItem.js';

export class PhoneFormItem extends BaseFormItem {
  constructor(element) {
    super();

    this.type = 'phone';
    this.input = element;
    this.isRequired = this.input.hasAttribute('required');
    this.value = element.value;
    this.errorElement = element
      .closest('.js-form-item-parent')
      .querySelector('.errorText');

    this.input.addEventListener('blur', () => this.validate());
  }

  validate() {
    this.value = this.input.value;

    const phoneReg = new RegExp(/^\d{2,5}-?\d{1,4}-?\d{4}$/);

    if (this.isRequired && !this.value) {
      this.addMessage('必須入力です。');
    } else if (this.value && !phoneReg.test(this.value)) {
      this.addMessage('形式が正しくありません。');
    } else {
      this.removeMessage();
    }
  }
}
