const header = document.querySelector(".header");

const scrollHandler = window.addEventListener("scroll", () => {
  const scrollPosition = window.pageYOffset || window.scrollY;

  if (scrollPosition > 0) {
    header.style.backgroundColor = "var(--header-bg-scroll)";
  } else {
    header.style.backgroundColor = "unset";
  }
});

window.onunload = function () {
  document.body.removeEventListener("scroll", scrollHandler);
};
