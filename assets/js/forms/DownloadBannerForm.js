/**
 * @fileoverview
 * Downloadバナー内フォーム用のフォームクラス。
 * 入力項目をまとめてバリデーションし、HubSpot送信用のfieldsを作って BaseForm に委譲します。
 *
 * 前提DOM/データ（利用側）:
 * - .js-download-banner-form 配下に各入力要素が存在する
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

export class DownloadBannerForm extends BaseForm {
  constructor(
    { company = '', lastname = '', email = '', phone = '', price_pulldown = '' },
    formData
  ) {
    super(formData);

    this.addItem('company', new TextFormItem(company));
    this.addItem('lastname', new TextFormItem(lastname));
    this.addItem('email', new EmailFormItem(email));
    this.addItem('phone', new PhoneFormItem(phone));
    this.addItem('price_pulldown', new SelectFormItem(price_pulldown));
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
