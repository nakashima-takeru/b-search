/**
 * @fileoverview
 * カルーセル型フォーム（複数ステップ入力）を制御するフォームクラス。
 * 入力ステップに応じて対象Itemをバリデーションし、送信データを整形して BaseForm に委譲します。
 *
 * 前提DOM/データ:
 * - form.dataset.step を現在ステップの表示制御に利用
 *
 * 依存:
 * - BaseForm（送信処理）
 * - TextFormItem / EmailFormItem / PhoneFormItem / SelectFormItem（入力バリデーション）
 */
import { BaseForm } from '../lib/BaseForm.js';
import {
  TextFormItem,
  EmailFormItem,
  PhoneFormItem,
  SelectFormItem,
} from './items/index.js';

export class CarouselForm extends BaseForm {
  currentStep = 1;
  constructor(
    form,
    { lastname = '', email = '', phone = '', company = '', price_pulldown = '' },
    formData
  ) {
    super(formData);
    this.form = form;

    this.addItem('lastname', new TextFormItem(lastname));
    this.addItem('email', new EmailFormItem(email));
    this.addItem('phone', new PhoneFormItem(phone));
    this.addItem('company', new TextFormItem(company));
    this.addItem('price_pulldown', new SelectFormItem(price_pulldown));

    this.setTabindex();
  }

  get currentStep() {
    return this.currentStep;
  }

  validateItem() {
    let currentItem = null;
    // フォームアイテムのvalidation
    if (this.currentStep === 1) {
      currentItem = this.items['lastname'];
    } else if (this.currentStep === 2) {
      currentItem = this.items['email'];
    } else if (this.currentStep === 3) {
      currentItem = this.items['phone'];
    } else if (this.currentStep === 4) {
      currentItem = this.items['company'];
    } else if (this.currentStep === 5) {
      currentItem = this.items['price_pulldown'];
    }

    currentItem.validate();
    return currentItem;
  }

  next() {
    if (this.currentStep >= 5) return;

    this.currentStep++;

    this.form.dataset.step = this.currentStep;
  }

  return() {
    if (this.currentStep <= 1) return;

    this.currentStep--;

    this.form.dataset.step = this.currentStep;
  }

  setTabindex() {
    Object.values(this.items).forEach((formItem, index) => {
      if (this.currentStep - 1 === index) {
        formItem.input.tabIndex = 0;
      } else {
        formItem.input.tabIndex = -1;
      }
    });
  }

  /**
   *　送信するデータを整理する関数
   *
   * @param {Event} event クリックイベント
   * @param {String} formValue フォームの名前・バリュー
   * @param {String} redirectSlug リダイレクト先のスラッグ
   * @returns
   */
  prepareFormData(event, formValue, redirectSlug) {
    event.preventDefault();

    if (this.invalid || this.isSending) return;

    // 送信する内容を整理
    const fields = [
      ...Object.entries(this.items).map(([name, formItem]) => ({
        name,
        value: formItem.value,
      })),
      { name: 'form', value: formValue },
    ];

    this.handleFormSubmission(fields, redirectSlug);
  }
}
