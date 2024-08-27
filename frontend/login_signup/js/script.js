const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});

const pswrdField = document.querySelector(
    ".sign-in-form .input-wrap input[type='password']"
  ),
  showHide = document.querySelector(".sign-in-form .input-wrap i");

showHide.onclick = () => {
  if (pswrdField.type === "password") {
    pswrdField.type = "text";
    showHide.classList.add("active");
  } else {
    pswrdField.type = "password";
    showHide.classList.remove("active");
  }
};

const pswrdField1 = document.querySelector(
    ".sign-up-form .input-wrap input[type='password']"
  ),
  showHide1 = document.querySelector(".sign-up-form .input-wrap i");

showHide1.onclick = () => {
  if (pswrdField1.type === "password") {
    pswrdField1.type = "text";
    showHide1.classList.add("active");
  } else {
    pswrdField1.type = "password";
    showHide1.classList.remove("active");
  }
};
