const headerBurgerButton = document.querySelector(".header__burger");
const navigationDrawerCloseButton = document.querySelector(
  ".navigation-drawer__close"
);
const navigationDrawer = document.querySelector(".navigation-drawer");
const body = document.querySelector("body");

if (navigationDrawerCloseButton) {
  navigationDrawerCloseButton.onclick = () => {
    navigationDrawer.classList.remove("navigation-drawer--open");

    navigationDrawer.classList.add("navigation-drawer--close");
    body.style.overflow = "initial";

    setTimeout(() => {
      navigationDrawer.style.visibility = "hidden";
    }, 300);
  };
}

if (headerBurgerButton) {
  headerBurgerButton.onclick = () => {
    navigationDrawer.classList.remove("navigation-drawer--close");

    navigationDrawer.style.visibility = "visible";
    navigationDrawer.classList.add("navigation-drawer--open");
    body.style.overflow = "hidden";
  };
}
