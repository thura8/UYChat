document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".typing-area");
  const inputField = form.querySelector(".input-field");
  const sendBtn = form.querySelector("button[type='submit']");
  const chatBox = document.querySelector(".chat-box");
  const photoInput = form.querySelector("#photo-input");
  const photoButton = form.querySelector("#photo-button");

  // Prevent form from submitting traditionally
  form.onsubmit = (e) => {
    e.preventDefault();
  };

  // Send text message on clicking the send button
  sendBtn.onclick = () => {
    sendTextMessage();
  };

  // Trigger the file input when the photo button is clicked
  photoButton.onclick = () => {
    photoInput.click();
  };

  // Handle image selection
  photoInput.onchange = () => {
    const file = photoInput.files[0];
    if (file) {
      sendImage(file); // Send the image
    }
  };

  // Function to send text messages
  function sendTextMessage() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/UYChat/backend/home/php/insert-chat.php", true);

    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          inputField.value = ""; // Clear the text input field

          // Reload chat messages
          loadChatMessages();
          scrollToBottom(); // Scroll to the bottom of the chat box
        }
      }
    };

    let formData = new FormData(form); // Create a FormData object from the form
    xhr.send(formData); // Send the form data to the PHP script
  }

  // Function to send images
  function sendImage(file) {
    let formData = new FormData();
    formData.append("photo", file); // Append the file to FormData

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/UYChat/backend/home/php/insert-chat.php", true);

    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Reload chat messages
          loadChatMessages();
          scrollToBottom(); // Scroll to the bottom of the chat box
        }
      }
    };

    xhr.send(formData); // Send the image data to the PHP script
  }

  // Function to load chat messages via AJAX
  function loadChatMessages() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/UYChat/backend/home/php/get-chat.php", true);

    xhr.onload = function () {
      if (xhr.status === 200) {
        chatBox.innerHTML = xhr.responseText; // Update chat box with the response
        if (!chatBox.classList.contains("active")) {
          scrollToBottom(); // Scroll to the bottom if the chat box is not active
        }
      }
    };

    // Ensure form elements exist before appending their values
    let outgoingId = form.querySelector('input[name="outgoing_id"]');
    let incomingId = form.querySelector('input[name="incoming_id"]');
    let groupId = form.querySelector('input[name="group_id"]');

    let formData = new FormData();
    if (outgoingId) formData.append("outgoing_id", outgoingId.value);
    if (incomingId) formData.append("incoming_id", incomingId.value || "");
    if (groupId) formData.append("group_id", groupId.value || "");

    xhr.send(formData); // Send the form data to the PHP script
  }

  // Handle chat box scrolling
  chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
  };

  chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
  };

  function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight; // Scroll the chat box to the bottom
  }

  // Update the chat messages every 5 seconds
  setInterval(loadChatMessages, 1000);
});

// JavaScript for handling the pop-up
document.addEventListener("DOMContentLoaded", function () {
  const editGroupBtn = document.getElementById("editGroupBtn"),
    editGroupPopup = document.getElementById("editGroupPopup"),
    closeBtn = document.querySelector(".closeGroup"),
    leaveGroupBtn = document.getElementById("leaveGroup"),
    saveChangesBtn = document.getElementById("saveChanges"),
    groupNameInput = document.getElementById("groupName"),
    groupIdInput = document.getElementById("groupId");

  // Show the popup
  editGroupBtn.onclick = function () {
    editGroupPopup.style.display = "block";
  };

  // Close the popup
  closeBtn.onclick = function () {
    editGroupPopup.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target === editGroupPopup) {
      editGroupPopup.style.display = "none";
    }
  };

  // Handle Save Changes button click
  saveChangesBtn.onclick = function () {
    const groupName = groupNameInput.value;
    const groupId = groupIdInput.value;

    console.log("group_id: ", groupId);
    console.log("groupName: ", groupName);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/UYChat/backend/home/php/update_group.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          if (xhr.responseText === "success") {
            alert("Group name updated successfully.");
            location.reload(); // Reload the page to reflect changes
          } else {
            alert("Failed to update group name.");
          }
        } else {
          alert("An error occurred while updating the group name.");
        }
      }
    };
    xhr.send(
      `group_id=${encodeURIComponent(groupId)}&groupName=${encodeURIComponent(
        groupName
      )}`
    );
  };

  // Handle Leave Group button click
  leaveGroupBtn.onclick = function () {
    const groupId = groupIdInput.value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/UYChat/backend/home/php/leave_group.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          if (xhr.responseText === "success") {
            alert("You have left the group.");
            window.location.href = "home.php"; // Redirect to the home page or any other page
          } else {
            alert("Failed to leave the group.");
          }
        } else {
          alert("An error occurred while leaving the group.");
        }
      }
    };
    xhr.send(`group_id=${encodeURIComponent(groupId)}`);
  };
});
