const form1 = document.querySelector(".sign-in-form"),
  signInBtn = form1.querySelector(".sign-in-btn"),
  errorText1 = form1.querySelector(".error-txt");

form1.onsubmit = (e) => {
  e.preventDefault(); // preventing form from submitting
};

signInBtn.onclick = () => {
  // let's start Ajax
  let xhr = new XMLHttpRequest(); //creating XML object
  xhr.open("POST", "/UYChat/backend/login_signup/php/login.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        // console.log(data);
        if (data == "success") {
          errorText1.style.display = "none";
          location.href = "../home/home.php";
        } else {
          errorText1.textContent = data;
          errorText1.style.display = "block";
        }
      }
    }
  };

  //we have to send the form data through ajax to php
  let formData1 = new FormData(form1); // creating new formData object
  xhr.send(formData1); // sending the form data to php
};
