function createInputName() {
  var max_level = parseInt(document.getElementById("input4").value);
  var input_name = document.getElementById("input5");
  input_name.innerHTML = "";
  if (!isNaN(max_level) && max_level >= 1) {
    for (let i = 0; i < max_level; i++) {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "floor_name[]";
      input.size = "40";
      input.value = "";
      input.required = true;
      input.className = "input-floor";
      input.addEventListener("input", onInputChange);
      input_name.appendChild(input);
    }
  }
}
window.onload = function () {
  createInputName();
};

function createInput() {
  var maxLevel = parseInt(document.getElementById("in4").value);
  var inputName = document.getElementById("in5");
  inputName.innerHTML = "";
  if (!isNaN(maxLevel) && maxLevel >= 1) {
    for (var i = 0; i < maxLevel; i++) {
      var input = document.createElement("input");
      input.type = "text";
      input.name = "floor_name[]";
      input.size = "40";
      input.className = "input-floor";
      input.required = true;
      inputName.appendChild(input);
      input.addEventListener("input", onInputChange);
    }
  }
}

function onInputChange() {
  var i5 = document.querySelectorAll(".input-floor");
  var cir5 = document.getElementById("circle5");
  checkInputs(i5, cir5);
}

const toggleBtn = document.querySelector(".toggle_btn");
const toggleBtnIcon = document.querySelector(".toggle_btn i");
const dropDownMenu = document.querySelector(".dropdown_menu");

toggleBtn.onclick = function () {
  dropDownMenu.classList.toggle("open");
  const isOpen = dropDownMenu.classList.contains("open");

  toggleBtnIcon.classList = isOpen ? "fa-solid fa-xmark" : "fa-solid fa-bars";
};

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("form_head").addEventListener("submit", function (e) {
    var lift_name = document.getElementById("input2").value;
    var mac_address = document.getElementById("input3").value;
    var max_level = document.getElementById("input4").value;
    var add_org = document.getElementById("add_org").value;
    var edit_org = document.getElementById("edit_org").value;
    // var floor_name = document.getElementsByClassName("input-floor").value;
    var floor_name = document.getElementsByClassName("input-floor");

    for (let i = 0; i < floor_name.length; i++) {
      if (floor_name[i].value.trim() === "") {
        e.preventDefault(); // ยกเลิกการส่ง form
        alert("กรุณากรอกข้อมูลในช่องทั้งหมด");
        return;
      }
    }

    if (!lift_name || !mac_address || !max_level || !add_org || !edit_org) {
      alert("กรุณากรอกทุกช่อง");
      e.preventDefault(); // ยกเลิกการส่งฟอร์ม
    }
  });

  const select = document.getElementById("select");
  const input2 = document.getElementById("input2");
  const input3 = document.getElementById("input3");
  const input4 = document.getElementById("input4");
  const in4 = document.getElementById("in4");

  const circle1 = document.getElementById("circle1");
  const circle2 = document.getElementById("circle2");
  const circle3 = document.getElementById("circle3");
  const circle4 = document.getElementById("circle4");

  if (select && circle1) {
    select.addEventListener("change", () => {
      if (select.value.trim() !== "") {
        circle1.classList.add("correct");
        circle1.classList.remove("incorrect");
      } else {
        circle1.classList.add("incorrect");
        circle1.classList.remove("correct");
      }
    });
  } else {
    console.error('Element with id "select" or "circle1" does not exist.');
  }

  if (input2 && circle2) {
    input2.addEventListener("input", () => {
      if (input2.value && input2.value.trim() !== "") {
        circle2.classList.add("correct");
        circle2.classList.remove("incorrect");
      } else {
        circle2.classList.add("incorrect");
        circle2.classList.remove("correct");
      }
    });
  } else {
    console.error('Element with id "input2" or "circle2" does not exist.');
  }

  if (input3 && circle3) {
    input3.addEventListener("input", () => {
      if (input3.value && input3.value.trim() !== "") {
        circle3.classList.add("correct");
        circle3.classList.remove("incorrect");
      } else {
        circle3.classList.add("incorrect");
        circle3.classList.remove("correct");
      }
    });
  } else {
    console.error('Element with id "input3" or "circle3" does not exist.');
  }

  if (input4 && circle4) {
    input4.addEventListener("input", () => {
      if (input4.value && input4.value.trim() !== "") {
        circle4.classList.add("correct");
        circle4.classList.remove("incorrect");
      } else {
        circle4.classList.add("incorrect");
        circle4.classList.remove("correct");
      }
    });
  } else {
    console.error('Element with id "input4" or "circle4" does not exist.');
  }
  if (in4 && circle4) {
    in4.addEventListener("input", () => {
      if (in4.value && in4.value.trim() !== "") {
        circle4.classList.add("correct");
        circle4.classList.remove("incorrect");
      } else {
        circle4.classList.add("incorrect");
        circle4.classList.remove("correct");
      }
    });
  } else {
    console.error('Element with id "in4" or "circle4" does not exist.');
  }

  var cir5 = document.getElementById("circle5");
  var i5 = document.getElementsByClassName("input-floor");

  Array.from(i5).forEach((input) => {
    input.addEventListener("input", () => {
      checkInputs(i5, cir5);
    });
  });

  // checkInputs(i5, cir5);
});

function checkInputs(i5, cir5) {
  var allFilled = Array.from(i5).every((input) => input.value.trim() !== "");
  var someFilled = Array.from(i5).some((input) => input.value.trim() !== ""); // ใช้ some ในกรณีนี้

  if (allFilled) {
    cir5.classList.add("correct");
    cir5.classList.remove("incorrect");
  } else if (someFilled) {
    cir5.classList.add("incorrect");
    cir5.classList.remove("correct");
  } else {
    cir5.classList.add("incorrect");
    cir5.classList.remove("correct");
  }
}
