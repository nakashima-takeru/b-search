/**
 * @fileoverview
 * SP/タブレット向けのグローバルドロワーメニュー制御。
 * ハンバーガーボタンでメニューを開閉し、必要に応じてドロップダウンをGSAPでアニメーションします。
 *
 * 前提DOM（例）:
 * - .js-global-hamburger-menu-btn
 * - .global-hamburger-menu
 * - .js-global-hamburger-menu-overlay
 * - .js-global-hamburger-dropdown-toggle（aria-controls を持つ）
 *
 * 依存:
 * - gsap（グローバル）
 */
export class DrawerMenu {
  static ANIMATION = {
    DURATION: 0.4,
    EASE: "cubic-bezier(0.26, 0.16, 0.1, 1)"
  };
  static DROPDOWN_ANIMATION = {
    OPEN_DURATION: 0.4,
    CLOSE_DURATION: 0.3,
    EASE: "cubic-bezier(0.26, 0.16, 0.1, 1)"
  };

  constructor() {
    this.hamburgerButtons = document.querySelectorAll(".js-global-hamburger-menu-btn");
    this.hamburgerMenu = document.querySelector(".global-hamburger-menu");
    this.menuLinks = document.querySelectorAll(".js-global-hamburger-menu-link");
    this.menuContents = document.querySelectorAll(".js-global-hamburger-menu-contents");
    this.menuOverlay = document.querySelector(".js-global-hamburger-menu-overlay");
    this.allMenuButtons = document.querySelectorAll(".js-global-hamburger-menu-contents-all");
    this.dropdownToggles = document.querySelectorAll(".js-global-hamburger-dropdown-toggle");

    this.isMenuOpen = false;

    if (!this.hamburgerMenu) {
      console.warn('DrawerMenu: Hamburger menu element not found');
      return;
    }

    this.init();
  }

  init() {
    this.setupHamburgerButtons();
    this.setupDropdownToggles();
    if (this.menuOverlay) {
      this.setupMenuLinks();
      this.setupAllMenuButtons();
      this.setupOverlay();
    }
  }

  setupHamburgerButtons() {
    if (!this.hamburgerButtons.length) {
      console.warn('DrawerMenu: No hamburger buttons found');
      return;
    }

    this.hamburgerButtons.forEach(button => {
      button.addEventListener("click", () => {
        this.isMenuOpen = !this.isMenuOpen;

        if (this.isMenuOpen) {
          document.body.style.overflow = "hidden";
          gsap.to(this.hamburgerMenu, {
            duration: DrawerMenu.ANIMATION.DURATION,
            ease: DrawerMenu.ANIMATION.EASE,
            display: "block",
            opacity: 1
          });
        } else {
          document.body.style.overflow = "";
          this.closeAllDropdowns(true);
          gsap.to(this.hamburgerMenu, {
            duration: DrawerMenu.ANIMATION.DURATION,
            ease: DrawerMenu.ANIMATION.EASE,
            display: "none",
            opacity: 0
          });
        }
      });
    });
  }

  resetAllMenuItems() {
    if (!this.menuOverlay) {
      console.warn('DrawerMenu: Menu overlay not found');
      return;
    }

    this.menuLinks.forEach(link => {
      link.classList.remove("is-active");
    });

    this.menuContents.forEach(content => {
      content.classList.remove("is-active");
    });

    this.menuOverlay.classList.remove("is-active");
  }

  setupMenuLinks() {
    if (!this.menuLinks.length) {
      console.warn('DrawerMenu: No menu links found');
      return;
    }

    this.menuLinks.forEach(link => {
      link.addEventListener("click", (event) => {
        event.preventDefault();

        const clickedLink = event.currentTarget;
        const targetId = clickedLink.dataset.id;

        if (!targetId) {
          console.warn('DrawerMenu: data-id attribute not found on menu link');
          return;
        }

        const targetContent = document.querySelector(`#${targetId}`);
        if (!targetContent) {
          console.warn(`DrawerMenu: Target content with id "${targetId}" not found`);
          return;
        }

        this.resetAllMenuItems();

        targetContent.classList.add("is-active");
        clickedLink.classList.add("is-active");
        this.menuOverlay.classList.add("is-active");
      });
    });
  }

  setupAllMenuButtons() {
    if (!this.allMenuButtons.length) {
      console.warn('DrawerMenu: No all menu buttons found');
      return;
    }

    this.allMenuButtons.forEach(button => {
      button.addEventListener("click", () => {
        this.resetAllMenuItems();
      });
    });
  }

  setupOverlay() {
    if (!this.menuOverlay) {
      console.warn('DrawerMenu: Menu overlay not found');
      return;
    }

    this.menuOverlay.addEventListener("click", () => {
      this.resetAllMenuItems();
    });
  }

  /**
   * ハンバーガーメニュー内のドロップダウントグルにクリックイベントを設定します。
   * 複数のドロップダウンを同時に展開できる仕様です。
   * @returns {void}
   */
  setupDropdownToggles() {
    if (!this.dropdownToggles.length) return;

    this.dropdownToggles.forEach(toggle => {
      toggle.addEventListener("click", (event) => {
        event.preventDefault();

        const submenu = this.getDropdownSubmenu(toggle);
        if (!submenu) return;

        const isExpanded = toggle.getAttribute("aria-expanded") === "true";
        if (isExpanded) {
          this.closeDropdown(toggle, submenu);
        } else {
          this.openDropdown(toggle, submenu);
        }
      });
    });
  }

  /**
   * トグルの `aria-controls` から、対象のサブメニュー要素を取得します。
   * @param {HTMLElement} toggle
   * @returns {HTMLElement|null}
   */
  getDropdownSubmenu(toggle) {
    const submenuId = toggle.getAttribute("aria-controls");
    if (!submenuId) {
      console.warn('DrawerMenu: aria-controls attribute not found on dropdown toggle');
      return null;
    }

    const submenu = document.getElementById(submenuId);
    if (!submenu) {
      console.warn(`DrawerMenu: Dropdown submenu with id "${submenuId}" not found`);
      return null;
    }

    return submenu;
  }

  /**
   * GSAPで高さ/透明度のアニメーションを行い、サブメニューを開きます。
   * @param {HTMLElement} toggle
   * @param {HTMLElement} submenu
   * @returns {void}
   */
  openDropdown(toggle, submenu) {
    const menuItem = toggle.closest(".global-hamburger-menu__item");
    toggle.setAttribute("aria-expanded", "true");
    menuItem?.classList.add("is-open");

    const prefersReducedMotion = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
    if (prefersReducedMotion) {
      submenu.hidden = false;
      submenu.style.height = "";
      submenu.style.opacity = "";
      return;
    }

    gsap.killTweensOf(submenu);

    const startHeight = submenu.hidden ? 0 : submenu.offsetHeight;
    submenu.hidden = false;

    gsap.set(submenu, { height: startHeight, opacity: startHeight ? 1 : 0 });
    gsap.to(submenu, {
      duration: DrawerMenu.DROPDOWN_ANIMATION.OPEN_DURATION,
      ease: DrawerMenu.DROPDOWN_ANIMATION.EASE,
      height: "auto",
      opacity: 1,
      onComplete: () => {
        gsap.set(submenu, { clearProps: "height" });
      }
    });
  }

  /**
   * GSAPで高さ/透明度のアニメーションを行い、サブメニューを閉じます。
   * @param {HTMLElement} toggle
   * @param {HTMLElement} submenu
   * @returns {void}
   */
  closeDropdown(toggle, submenu) {
    const menuItem = toggle.closest(".global-hamburger-menu__item");
    toggle.setAttribute("aria-expanded", "false");
    menuItem?.classList.remove("is-open");

    if (submenu.hidden) {
      return;
    }

    const prefersReducedMotion = window.matchMedia?.("(prefers-reduced-motion: reduce)")?.matches;
    if (prefersReducedMotion) {
      submenu.hidden = true;
      submenu.style.height = "";
      submenu.style.opacity = "";
      return;
    }

    gsap.killTweensOf(submenu);
    gsap.set(submenu, { height: submenu.offsetHeight, opacity: 1 });
    gsap.to(submenu, {
      duration: DrawerMenu.DROPDOWN_ANIMATION.CLOSE_DURATION,
      ease: DrawerMenu.DROPDOWN_ANIMATION.EASE,
      height: 0,
      opacity: 0,
      onComplete: () => {
        submenu.hidden = true;
        gsap.set(submenu, { clearProps: "height,opacity" });
      }
    });
  }

  /**
   * すべてのドロップダウンを閉じます。
   * @param {boolean} [immediate=false] `true` の場合はアニメーション無しで即時に閉じ、インラインスタイルもリセットします。
   * @returns {void}
   */
  closeAllDropdowns(immediate = false) {
    if (!this.dropdownToggles.length) return;

    this.dropdownToggles.forEach(toggle => {
      const submenu = this.getDropdownSubmenu(toggle);
      if (!submenu) return;

      if (immediate) {
        toggle.setAttribute("aria-expanded", "false");
        toggle.closest(".global-hamburger-menu__item")?.classList.remove("is-open");
        gsap.killTweensOf(submenu);
        submenu.hidden = true;
        submenu.style.height = "";
        submenu.style.opacity = "";
        return;
      }

      this.closeDropdown(toggle, submenu);
    });
  }
}
