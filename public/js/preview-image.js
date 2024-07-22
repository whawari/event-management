const previewImage = (event) => {
  const reader = new FileReader();

  reader.onload = function () {
    const element = document.querySelector(".form__field__file__img");

    element.src = reader.result;
    element.style.display = "block";
  };

  try {
    reader.readAsDataURL(event.target.files[0]);
  } catch (error) {}
};
