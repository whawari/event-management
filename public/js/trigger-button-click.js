const triggerButtonClick = (event) => {
  if (event.keyCode === 13) {
    // 13 is the Enter key
    const element = event.target;

    element.click();
  }
};
