const wrapper = document.querySelector(".wrapper"),
  selectBtn = wrapper.querySelector(".select-btn"),
  options = wrapper.querySelector(".options"),
  hiddenInput = document.getElementById("selected-major"); // Hidden input field

let majors = [
  "Anthropology",
  "Archaeology",
  "Biochemistry",
  "Botany",
  "Chemistry",
  "Computer Science",
  "English",
  "Environmental Science",
  "Environmental Studies",
  "Fisheries and Aquaculture",
  "Geography",
  "Geology",
  "History",
  "Industrial Chemistry",
  "International Relations",
  "Law",
  "Libraries and Information studies",
  "Mathematics",
  "Microbiology",
  "Myanmar",
  "Oriental Studies",
  "Philosophy",
  "Physics",
  "Political Science",
  "Psychology",
  "Zoology",
];

function addMajor(selectedMajor) {
  options.innerHTML = "";

  majors.forEach((major) => {
    let isSelected = major == selectedMajor ? "selected" : "";

    let li = `<li onclick="updateName(this)" value="${major}" class="${isSelected}">${major}</li>`;
    options.innerHTML += li;
  });
}

addMajor();

function updateName(selectedLi) {
  addMajor(selectedLi.innerText);

  wrapper.classList.remove("active");
  selectBtn.firstElementChild.innerText = selectedLi.innerText;

  // Update the hidden input with the selected major
  hiddenInput.value = selectedLi.innerText;
  console.log(hiddenInput);
}

selectBtn.addEventListener("click", () => {
  wrapper.classList.toggle("active");
});
