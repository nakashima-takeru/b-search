/**
 * @fileoverview
 * select入力用のフォームItem。
 * 直接 SELECT を渡す場合と、ラッパー要素（内部に select を持つ）を渡す場合の両方を想定しています。
 *
 * 前提DOM（例）:
 * - 入力要素（またはラッパー）の親に .js-form-item-parent
 * - 親内に .errorText（エラー表示）
 */
import { BaseFormItem } from '../../lib/BaseFormItem.js';

export class SelectFormItem extends BaseFormItem {
  constructor(element) {
    super();

    this.type = 'select';
    this.input = element;
    this.isRequired = this.input.hasAttribute('required');

    if (this.input.tagName === 'SELECT') {
      this.value = element.value;
    } else {
      this.value = element.getElementsByTagName('select')[0].value;
    }
    this.errorElement = element
      .closest('.js-form-item-parent')
      .querySelector('.errorText');

    this.input.addEventListener('change', () => this.validate());
  }

  validate() {
    this.value = this.input.value;

    if (this.input.tagName === 'SELECT') {
      this.value = this.input.value;
    } else {
      this.value = this.input.getElementsByTagName('select')[0].value;
    }

    if (this.isRequired && !this.value) {
      this.addMessage('必須入力です。');
    } else {
      this.removeMessage();
    }
  }
}
