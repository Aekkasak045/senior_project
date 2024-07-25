// function getData(id) {
//   let loadData = new XMLHttpRequest();
//   loadData.onreadystatechange = function () {
//     if (loadData.readyState === 4 && loadData.status === 200) {
//       let data = JSON.parse(loadData.responseText);
//       liftState = data.lift_state;
//       maxLevel = data.max_level;
//       upStatus = data.up_status;
//       downStatus = data.down_status;
//       carStatus = data.car_status;
//       levelName = data.floor_name;
//       nameFloor = data.levelName.split(",");
//       connectionStatus = data.connection_status;
//       updateUI(
//         id,
//         maxLevel,
//         liftState,
//         upStatus,
//         downStatus,
//         carStatus,
//         nameFloor,
//         connectionStatus
//       );
//     }
//   };
//   loadData.open(
//     "GET",
//     "http://52.221.67.113/smartlift/get_status.php?lift_id=" + id,
//     true
//   );
//   loadData.send();
// }
// function updateUI(
//   id,
//   maxLevel,
//   liftState,
//   upStatus,
//   downStatus,
//   carStatus,
//   nameFloor,
//   connectionStatus
// ) {
//   createInput(id, nameFloor);
// }
// function createInput(id, nameFloor) {
//   var max_level = parseInt(document.getElementById("input4").value);
//   var inputFieldsContainer = document.getElementById("input5_" + id);
//   var counter = 1;
//   // inputFieldsContainer.innerHTML = "";

//   // if (!isNaN(max_level) && max_level >= 1)
//   // {
//   for (var i = 0; i < max_level; i++) {
//     if (counter <= nameFloor.length) {
//       var input = document.createElement("input");
//       input.type = "text";
//       input.name = "floor_name";
//       input.size = "40";
//       input.value = nameFloor[counter - 1];
//       // input.placeholder = `Input floor name`;
//       input.className = "input-floor";
//       inputFieldsContainer.appendChild(input);
//       counter++;
//     } else {
//       break;
//     }
//   }
// }
// }

// window.onload = function () {
//   createInputFields();
// };

function createInputFields() {
  const max_level = parseInt(document.getElementById("input4").value);
  const inputFieldsContainer = document.getElementById("input5");
  inputFieldsContainer.innerHTML = "";
  if (!isNaN(max_level) && max_level >= 1) {
    for (let i = 0; i < max_level; i++) {
      const input = document.createElement("input");
      input.type = "text";
      input.name = "floor_name";
      input.size = "40";
      input.value = "";
      // input.placeholder = `Input floor name`;
      input.className = "input-floor";
      inputFieldsContainer.appendChild(input);
    }
  }
}

window.onload = function () {
  createInputFields();
};

const toggleBtn = document.querySelector(".toggle_btn");
const toggleBtnIcon = document.querySelector(".toggle_btn i");
const dropDownMenu = document.querySelector(".dropdown_menu");

toggleBtn.onclick = function () {
  dropDownMenu.classList.toggle("open");
  const isOpen = dropDownMenu.classList.contains("open");

  toggleBtnIcon.classList = isOpen ? "fa-solid fa-xmark" : "fa-solid fa-bars";
};

const select = document.getElementById("select");
const circle1 = document.getElementById("circle1");
select.addEventListener("change", () => {
  if (select.value.trim() !== "") {
    circle1.classList.add("correct");
    circle1.classList.remove("incorrect");
  } else {
    circle1.classList.add("incorrect");
    circle1.classList.remove("correct");
  }
});

const input2 = document.getElementById("input2");
const circle2 = document.getElementById("circle2");
input2.addEventListener("input", () => {
  if (input2.value.trim() !== "") {
    circle2.classList.add("correct");
    circle2.classList.remove("incorrect");
  } else {
    circle2.classList.add("incorrect");
    circle2.classList.remove("correct");
  }
});

const input3 = document.getElementById("input3");
const circle3 = document.getElementById("circle3");
input3.addEventListener("input", () => {
  if (input3.value.trim() !== "") {
    circle3.classList.add("correct");
    circle3.classList.remove("incorrect");
  } else {
    circle3.classList.add("incorrect");
    circle3.classList.remove("correct");
  }
});

const input4 = document.getElementById("input4");
const circle4 = document.getElementById("circle4");
input4.addEventListener("input", () => {
  if (input4.value.trim() !== "") {
    circle4.classList.add("correct");
    circle4.classList.remove("incorrect");
  } else {
    circle4.classList.add("incorrect");
    circle4.classList.remove("correct");
  }
});

const input5 = document.getElementById("input5");
const circle5 = document.getElementById("circle5");
input5.addEventListener("input", () => {
  if (input5.value.trim() !== "") {
    circle5.classList.add("correct");
    circle5.classList.remove("incorrect");
  } else {
    circle5.classList.add("incorrect");
    circle5.classList.remove("correct");
  }
});
