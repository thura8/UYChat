// Get elements
const makeGroupChatBtn = document.getElementById("make-group-chat-btn");
const groupChatPopup = document.getElementById("group-chat-popup");
const closeBtn = document.querySelector(".close-btn");
const createGroupBtn = document.getElementById("create-group-btn");
const usersListContainer = document.getElementById("users-list-group");

// Add event listeners
makeGroupChatBtn.addEventListener("click", showGroupChatPopup);
closeBtn.addEventListener("click", closeGroupChatPopup);
window.addEventListener("click", closeGroupChatPopupOutside);

// Functions
function showGroupChatPopup() {
  groupChatPopup.style.display = "block";
  fetchUsersList();
}

function closeGroupChatPopup() {
  groupChatPopup.style.display = "none";
}

function closeGroupChatPopupOutside(event) {
  if (event.target === groupChatPopup) {
    groupChatPopup.style.display = "none";
  }
}

function fetchUsersList() {
  console.log("Fetching users list ...");
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "/UYChat/backend/home/php/fetch-users.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const data = xhr.response;
      console.log(data);
      usersListContainer.innerHTML = data;
    }
  };
  xhr.send();
}

createGroupBtn.onclick = () => {
  let groupName = document.getElementById("group-name").value;
  let selectedUsers = Array.from(
    document.querySelectorAll('.user-item input[type="checkbox"]:checked')
  ).map((input) => input.value);

  if (groupName !== "" && selectedUsers.length > 0) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/UYChat/backend/home/php/create-group.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = () => {
      if (xhr.status === 200) {
        console.log(xhr.responseText); // Show the response message
        // Close the popup and refresh the chat list (if necessary)
        document.querySelector(".group-chat-popup").style.display = "none";
      }
    };

    let params = `group_name=${groupName}&participants[]=${selectedUsers.join(
      "&participants[]="
    )}`;
    xhr.send(params);
  } else {
    alert("Please enter a group name and select at least two participants.");
  }
};
