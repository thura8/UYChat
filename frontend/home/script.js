let MenuList = document.querySelectorAll(".MenuList li");

//for sidebar toggle

function activeLink() {
  MenuList.forEach((item) => item.classList.remove("active"));

  this.classList.add("active");
}

MenuList.forEach((item) => item.addEventListener("click", activeLink));

//for menulinks making hidden and displayed

const menuLinks = document.querySelectorAll(".menu-link");

menuLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const targetId = this.getAttribute("data-target");
    const contentDivs = document.querySelectorAll(".content > div");

    contentDivs.forEach((div) => {
      if (div.id == targetId) {
        div.classList.remove("hidden");
      } else {
        div.classList.add("hidden");
      }
    });
  });
});

// search bar

const searchBar = document.querySelector("#friends .search input"),
  searchBtn = document.querySelector("#friends .search button"),
  usersList = document.querySelector("#friends .users-list");

searchBtn.onclick = () => {
  if (searchBar.classList.contains("active")) {
    // If the input is already active, clear its content and hide it
    searchBar.value = "";
    searchBar.classList.remove("active");
    searchBtn.innerHTML = '<i class="fa fa-search"></i>';
  } else {
    // Otherwise, show the input and focus it
    searchBar.classList.add("active");
    searchBar.focus();
    searchBtn.innerHTML = '<i class="fa fa-times"></i>';
  }
};

// Event listener to change the button back if the input is empty and keep it active
searchBar.addEventListener("input", () => {
  if (searchBar.value.trim() === "") {
    searchBtn.innerHTML = '<i class="fa fa-times"></i>';
  } else {
    searchBtn.innerHTML = '<i class="fa fa-times"></i>';
  }
});

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;

  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }

  //let's start Ajax
  let xhr = new XMLHttpRequest(); // creating xml object
  xhr.open("POST", "/UYchat/backend/home/php/search.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        usersList.innerHTML = data;
      }
    }
  };

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
};

setInterval(() => {
  let xhr = new XMLHttpRequest(); // creating XML object
  xhr.open("GET", "/UYchat/backend/home/php/users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;

        if (!searchBar.classList.contains("active")) {
          // Preserve the open menus before updating the innerHTML
          let openMenus = [];
          document.querySelectorAll(".menu-content").forEach((menu, index) => {
            if (menu.style.display === "block") {
              openMenus.push(index);
            }
          });

          // Update the users list with the new data
          usersList.innerHTML = data;

          // Restore the open menus
          openMenus.forEach((index) => {
            document.querySelectorAll(".menu-content")[index].style.display =
              "block";
          });

          // Reattach the event listeners after updating the DOM
          // attachMenuListeners();
        }
      }
    }
  };
  xhr.send(); // make sure to send the request
}, 500); // this function will run frequently after 500ms
