/**
 * @fileoverview
 * 記事詳細（post）ページ用のページスクリプト。
 * - スライダー初期化
 * - Download Banner Form / Carousel Form の初期化
 * - TOC開閉
 * - ポップアップ/インタースティシャルバナー制御
 */
import { CarouselForm } from '../forms/CarouselForm.js';
import { DownloadBannerForm } from '../forms/DownloadBannerForm.js';
import { InterstitialBanner } from '../modules/interstitialBanner.js';
import { initBasicSlider } from '../modules/slider.js';
import { PopupBanner } from '../modules/popupBanner.js';
import { TOC } from '../modules/toc.js';

document.addEventListener('DOMContentLoaded', () => {
  initBasicSlider();

  // Download Banner Form
  const downloadBannerFormElement = document.querySelector(
    '.js-download-banner-form'
  );

  if (downloadBannerFormElement) {
    const submitButton = downloadBannerFormElement.querySelector(
      '.js-download-banner-form__submit'
    );

    const downloadBannerForm = new DownloadBannerForm(
      {
        company: downloadBannerFormElement.querySelector(
          '.js-download-banner-form__company'
        ),
        lastname: downloadBannerFormElement.querySelector(
          '.js-download-banner-form__lastname'
        ),
        email: downloadBannerFormElement.querySelector(
          '.js-download-banner-form__email'
        ),
        phone: downloadBannerFormElement.querySelector(
          '.js-download-banner-form__phone'
        ),
        price_pulldown: downloadBannerFormElement.querySelector(
          '.js-download-banner-form__price_pulldown'
        ),
      },
      {
        portalID: 7977366,
        formID: downloadBannerInfo[1],
      }
    );

    if (submitButton) {
      submitButton.addEventListener('click', (event) => {
        if (downloadBannerForm.checkInvalid()) return;

        submitButton.classList.add('loading');
        document.querySelector('.download-banner-button__text').textContent =
          '送信中。。';

        downloadBannerForm.prepareFormData(
          event,
          downloadBannerInfo[0],
          'thanks-pdf-download'
        );
      });
    }
  }

  // toc
  const toc = document.getElementById('toc_container');

  if (toc) {
    const handler = toc.querySelector('.toc_title');
    const content = toc.querySelector('.toc_list');

    new TOC(toc, handler, content);
  }

  // writer card
  const writerCards = document.querySelectorAll('.js-author');

  if (writerCards.length !== 0) {
    writerCards.forEach((card) => {
      const description = card.querySelector('.js-author__desc');
      const moreButton = card.querySelector('.js-author__more');
      if (description && description.getBoundingClientRect().height > 78) {
        card.classList.add('hidden');
      }

      moreButton.addEventListener('click', () => {
        card.classList.remove('hidden');
      });
    });
  }

  // ポップアップバナー
  const popupBannerElement = document.querySelector('.js-popup-banner');

  if (popupBannerElement) {
    new PopupBanner(popupBannerElement);
  }

  // Interstitial banner
  const interstitialBannerElement = document.querySelector(
    '.js-interstitial-banner'
  );
  if (interstitialBannerElement) {
    new InterstitialBanner(interstitialBannerElement);
  }

  // Carousel Form
  const carouselFormElements = Array.from(
    document.querySelectorAll('.js-carousel-form')
  );

  if (carouselFormElements.length !== 0) {
    carouselFormElements.forEach((form) => {
      const submitButton = form.querySelector('.js-carousel-form-submit');
      const nextButton = form.querySelector('.js-carousel-form-next');
      const returnButton = form.querySelector('.js-carousel-form-return');

      const carouselForm = new CarouselForm(
        form,
        {
          lastname: form.querySelector('.js-carousel-form__lastname'),
          email: form.querySelector('.js-carousel-form__email'),
          phone: form.querySelector('.js-carousel-form__phone'),
          company: form.querySelector('.js-carousel-form__company'),
          price_pulldown: form.querySelector('.js-carousel-form__price_pulldown'),
        },
        {
          portalID: 7977366,
          formID: form.dataset.formId,
        }
      );

      if (returnButton) {
        returnButton.addEventListener('click', () => {
          carouselForm.return();
          carouselForm.setTabindex();
        });
      }

      if (nextButton) {
        nextButton.addEventListener('click', () => {
          const currentItem = carouselForm.validateItem();
          if (!currentItem.invalid) {
            carouselForm.next();
            carouselForm.setTabindex();
          }
        });
      }

      if (submitButton) {
        submitButton.addEventListener('click', (event) => {
          const currentItem = carouselForm.validateItem();
          if (!currentItem.invalid && !carouselForm.checkInvalid()) {
            carouselForm.prepareFormData(
              event,
              form.dataset.formName,
              'thanks-pdf-download'
            );
          }
        });
      }
    });
  }
});
