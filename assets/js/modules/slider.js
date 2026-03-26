/**
 * @fileoverview
 * Splideを使った各種スライダーの初期化ユーティリティ。
 * 各ページJSから呼ばれ、該当DOMがある場合のみ Splide を生成してマウントします。
 *
 * 依存:
 * - Splide（グローバル。splide.min.js が先に読み込まれている想定）
 *
 * 提供API:
 * - initPickupSlider() / initUpdateSlider() / initBasicSlider() / initWriterSlider()
 */
export function initPickupSlider() {
  const rootElement = document.querySelector('.js-queryy-pickup-splide');
  if (!rootElement) return;

  const pickupSlider = new Splide(rootElement, {
    type: 'loop',
    gap: '4rem',
    width: '80%',
    focus: 'center',
    autoWidth: true,
    autoHeight: true,
    autoplay: true,
    pauseOnHover: false,
    pauseOnFocus: false,
    perPage: 3,
    updateOnMove: true,
  });

  pickupSlider.on('pagination:mounted', (data, item) => {
    data.items.forEach((item) => {
      createAndAppendCarouselButton(item.button);
    });

    animatePaginationHandler(pickupSlider, item);
  });

  pickupSlider.on('pagination:updated', (data, prev, curr) => {
    animatePaginationHandler(pickupSlider, curr);
  });

  pickupSlider.mount();
}

export function initUpdateSlider() {
  const rootElement = document.querySelector('.js-queryy-update-splide');
  if (!rootElement) return;

  const updateSlider = new Splide(rootElement, {
    type: 'loop',
    gap: '3rem',
    width: '100%',
    // focus: 'center',
    autoplay: true,
    autoWidth: true,
    pauseOnHover: false,
    pauseOnFocus: false,
  });

  updateSlider.on('pagination:mounted', (data, item) => {
    data.items.forEach((item) => {
      createAndAppendCarouselButton(item.button);
    });

    animatePaginationHandler(updateSlider, item);
  });

  updateSlider.on('pagination:updated', (data, prev, curr) => {
    animatePaginationHandler(updateSlider, curr);
  });

  updateSlider.mount();
}

export function initBasicSlider() {
  const targets = document.querySelectorAll('.js-queryy-basic-slider');
  if (targets.length === 0) return;

  targets.forEach((slider) => {
    const basicSlider = new Splide(slider, {
      type: 'loop',
      perPage: '4',
      perMove: '1',
      foucs: 'center',
      fixedWidth: '27rem',
      gap: '4rem',
      breakpoints: {
        768: {
          perPage: 2,
        },
        500: {
          perPage: 1,
        },
      },
    });

    basicSlider.mount();
  });
}

export function initWriterSlider() {
  const targets = document.querySelectorAll('.js-queryy-writer-slider');
  if (targets.length === 0) return;

  targets.forEach((slider) => {
    const basicSlider = new Splide(slider, {
      type: 'loop',
      perPage: '4',
      perMove: '1',
      foucs: 'center',
      fixedWidth: '22rem',
      gap: '10rem',
      breakpoints: {
        768: {
          perPage: 2,
          fixedWidth: '20rem',
          gap: '4rem',
        },
        500: {
          perPage: 1,
          fixedWidth: '18rem',
        },
      },
    });

    basicSlider.mount();
  });
}

function animatePaginationHandler(slider, currentPagination = null) {
  if (!currentPagination) {
    throw new Error('item is not found.');
  }

  const circumference = Number(
    getComputedStyle(currentPagination.button).getPropertyValue(
      '--stroke-dasharray'
    )
  );
  slider.off('autoplay:playing');

  slider.on('autoplay:playing', (rate) => {
    currentPagination.button.style.setProperty(
      '--stroke-dashoffset',
      circumference - circumference * rate
    );
  });
}

/**
 * ボタン要素の内部を作成する関数
 *
 * @param {HTMLButtonElement} button - 対象のボタン要素
 */
function createAndAppendCarouselButton(button) {
  const svgElement = document.createElementNS(
    'http://www.w3.org/2000/svg',
    'svg'
  );
  svgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
  svgElement.setAttribute('viewBox', '0 0 100 100');
  svgElement.setAttribute('class', 'carousel-pagination-btn__progress');

  const progressBg = document.createElementNS(
    'http://www.w3.org/2000/svg',
    'circle'
  );
  progressBg.setAttribute('cx', '50');
  progressBg.setAttribute('cy', '50');
  progressBg.setAttribute('r', '45');

  const progressBar = document.createElementNS(
    'http://www.w3.org/2000/svg',
    'circle'
  );
  progressBar.setAttribute('cx', '50');
  progressBar.setAttribute('cy', '50');
  progressBar.setAttribute('r', '45');

  progressBg.setAttribute('class', 'carousel-pagination-btn__progress-bg');
  svgElement.appendChild(progressBg);

  progressBar.setAttribute('class', 'carousel-pagination-btn__progress-bar');
  svgElement.appendChild(progressBar);

  const circle = document.createElement('div');
  circle.setAttribute('class', 'carousel-pagination-btn__circle');

  button.classList.add('carousel-pagination-btn');
  button.appendChild(svgElement);
  button.appendChild(circle);
}
