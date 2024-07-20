const sidebar = document.querySelector(".sidebar");
const sidebarResizeButton = document.querySelector(".sidebar__header__resize");
const toolbarBurgerButton = document.querySelector(".toolbar__burger");
const sidebarCloseButton = document.querySelector(".sidebar__header__close");
const sidebarWhitespace = document.querySelectorAll(".sidebar-whitespace");
const panel = document.querySelector(".panel");

const sidebarResizeButtonImg = sidebarResizeButton.children[0];

toolbarBurgerButton.onclick = () => {
  sidebar.classList.remove("sidebar--closed");
};

sidebarCloseButton.onclick = () => {
  sidebar.classList.add("sidebar--closed");
};

sidebarResizeButton.onclick = () => {
  const isOpened =
    sidebarResizeButton.getAttribute("data-toggle") === "opened" ? true : false;

  if (isOpened) {
    sidebarResizeButton.setAttribute("data-toggle", "closed");

    sidebar.style.width = "88px";

    sidebarWhitespace.forEach((element) => {
      element.style.width = "88px";
    });

    sidebar.classList.add("sidebar--minimized");

    sidebarResizeButtonImg.setAttribute(
      "src",
      "/event-management/public/images/icons/chevron-right.svg"
    );
  } else {
    sidebarResizeButton.setAttribute("data-toggle", "opened");

    sidebar.style.width = "300px";

    sidebarWhitespace.forEach((element) => {
      element.style.width = "300px";
    });

    sidebar.classList.remove("sidebar--minimized");

    sidebarResizeButtonImg.setAttribute(
      "src",
      "/event-management/public/images/icons/chevron-left.svg"
    );
  }
};
