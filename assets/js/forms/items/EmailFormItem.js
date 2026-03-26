/**
 * @fileoverview
 * メール入力用のフォームItem。
 * required の必須チェックと、簡易的なメール形式チェックを行います。
 *
 * 前提DOM（例）:
 * - 入力要素の親に .js-form-item-parent
 * - 親内に .errorText（エラー表示）
 */
import { BaseFormItem } from '../../lib/BaseFormItem.js';

export class EmailFormItem extends BaseFormItem {
  constructor(element) {
    super();

    this.type = 'email';
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

    const emailReg = new RegExp(
      /^[A-Za-z0-9]{1}[A-Za-z0-9_.+-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/
    );

    if (this.isRequired && !this.value) {
      this.addMessage('必須入力です。');
    } else if (this.value && !emailReg.test(this.value)) {
      this.addMessage('形式が正しくありません。');
    } else {
      this.removeMessage();
    }
  }
}
