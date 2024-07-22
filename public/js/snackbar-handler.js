const snackbar = document.querySelector(".snackbar");
const snackbarCloseButton = document.querySelector(".snackbar__close");

if (snackbar) {
  snackbar.style.visibility = "visible";
  snackbar.style.right = "24px";

  setTimeout(() => {
    hideSnackbar();
  }, 5000);
}

const hideSnackbar = () => {
  if (snackbar) {
    snackbar.style.right = "-100%";

    setTimeout(() => {
      snackbar.style.visibility = "hidden";
    }, 500);
  }
};

if (snackbarCloseButton) {
  snackbarCloseButton.onclick = () => {
    hideSnackbar();
  };
}
