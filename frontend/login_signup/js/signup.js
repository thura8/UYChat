const form = document.querySelector(".sign-up-form"),
  signUpBtn = form.querySelector(".sign-up-btn"),
  errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
  e.preventDefault(); // preventing form from submitting
};

signUpBtn.onclick = () => {
  // let's start Ajax
  let xhr = new XMLHttpRequest(); //creating XML object
  xhr.open("POST", "/UYChat/backend/login_signup/php/signup.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (data == "success") {
          errorText.style.display = "none";
          location.href = "../home/home.php";
        } else {
          errorText.textContent = data;
          errorText.style.display = "block";
        }
      }
    }
  };

  //we have to send the form data through ajax to php
  let formData = new FormData(form); // creating new formData object
  xhr.send(formData); // sending the form data to php
};
