const root = document.documentElement;
const modeSelect = document.querySelector("[data-mode-select]");
const themeSelect = document.querySelector("[data-theme-select]");
const modalOpenButtons = document.querySelectorAll("[data-modal-open]");
const modalCloseButtons = document.querySelectorAll("[data-modal-close]");

const storageKeys = {
  mode: "fandewarhammercms-mode",
  theme: "fandewarhammercms-theme",
};

const allowedModes = ["auto", "light", "dark"];
const allowedThemes = ["verdant", "cathedral"];

function readSetting(key, allowedValues, fallback) {
  let value = window.localStorage.getItem(key);

  if (key === storageKeys.theme && value === "aero") {
    value = "verdant";
    persistSetting(storageKeys.theme, "verdant");
  }

  if (value && allowedValues.includes(value)) {
    return value;
  }

  return fallback;
}

function applySetting(attribute, value) {
  root.setAttribute(attribute, value);
}

function persistSetting(key, value) {
  window.localStorage.setItem(key, value);
}

function initializeControls() {
  const mode = readSetting(storageKeys.mode, allowedModes, "auto");
  const theme = readSetting(storageKeys.theme, allowedThemes, "verdant");

  applySetting("data-mode", mode);
  applySetting("data-theme", theme);

  if (modeSelect) {
    modeSelect.value = mode;
    modeSelect.addEventListener("change", (event) => {
      const nextMode = event.target.value;

      if (!allowedModes.includes(nextMode)) {
        return;
      }

      applySetting("data-mode", nextMode);
      persistSetting(storageKeys.mode, nextMode);
    });
  }

  if (themeSelect) {
    themeSelect.value = theme;
    themeSelect.addEventListener("change", (event) => {
      const nextTheme = event.target.value;

      if (!allowedThemes.includes(nextTheme)) {
        return;
      }

      applySetting("data-theme", nextTheme);
      persistSetting(storageKeys.theme, nextTheme);
    });
  }
}

function initializeModals() {
  modalOpenButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const modalId = button.getAttribute("data-modal-open");
      const modal = document.getElementById(modalId);

      if (!modal || typeof modal.showModal !== "function") {
        return;
      }

      modal.showModal();
    });
  });

  modalCloseButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const dialog = button.closest("dialog");

      if (dialog) {
        dialog.close();
      }
    });
  });
}

initializeControls();
initializeModals();
