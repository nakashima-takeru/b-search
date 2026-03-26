/**
 * @fileoverview
 * テキスト入力用のフォームItem。
 * required 属性の有無に応じて必須チェックを行い、エラーメッセージを表示します。
 *
 * 前提DOM（例）:
 * - 入力要素の親に .js-form-item-parent
 * - 親内に .errorText（エラー表示）
 */
import { BaseFormItem } from '../../lib/BaseFormItem.js';

export class TextFormItem extends BaseFormItem {
  constructor(element) {
    super();

    this.type = 'text';
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

    if (this.isRequired && !this.value) {
      this.addMessage('必須入力です。');
    } else {
      this.removeMessage();
    }
  }
}
