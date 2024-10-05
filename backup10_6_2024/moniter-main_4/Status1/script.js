function getData(id) {
  let loadData = new XMLHttpRequest();
  loadData.onreadystatechange = function () {
    if (loadData.readyState === 4 && loadData.status === 200) {
      let data = JSON.parse(loadData.responseText);
      liftState = data.lift_state;
      maxLevel = data.max_level;
      upStatus = data.up_status;
      downStatus = data.down_status;
      carStatus = data.car_status;
      connectionStatus = data.connection_status;
      updateUI(
        id,
        maxLevel,
        liftState,
        upStatus,
        downStatus,
        carStatus,
        connectionStatus
      );
    }
  };
  loadData.open(
    "GET",
    "http://52.221.67.113/smartlift/get_status.php?lift_id=" + id,
    true
  );
  loadData.send();
}
function updateUI(
  id,
  maxLevel,
  liftState,
  upStatus,
  downStatus,
  carStatus,
  connectionStatus
) {
  updateLiftState(id, maxLevel, liftState, connectionStatus);
  updateUpStatus(id, maxLevel, upStatus);
  updateDownStatus(id, maxLevel, downStatus);
  updateCarStatus(id, maxLevel, carStatus);
}

function updateLiftState(id, maxLevel, liftState, connectionStatus) {
  current_level = parseInt(liftState.substring(0, 2), 16);
  // icDoor = document.getElementById("ic_door_" + id);
  door = document.getElementById("door_" + id);
  mode = document.getElementById("mode_" + id);
  connection = document.getElementById("connection_" + id);
  door.innerHTML = checkDoorText(liftState);
  // icDoor.innerHTML = checkDoorIcon(liftState);
  // console.log(icDoor);
  mode.innerHTML = checkWorkingStatus(liftState);
  error = checkError(liftState);
  connection.innerHTML = connectionStatus;
  if (connectionStatus == "Offline") {
    connection.classList.add("conn_after1");
    connection.classList.remove("conn_after2");
  } else {
    connection.classList.remove("conn_after1");
    connection.classList.add("conn_after2");
  }
  for (i = 0; i < maxLevel; i++) {
    lift_level = document.getElementById("num_" + id + "_" + (i + 1));
    circle_level = document.getElementById("circle_" + id + "_" + (i + 1));

    if (current_level == i + 1) {
      if (error != "1" && error != "2") {
        lift_level.classList.add("background_text1");
        circle_level.classList.add("circle_background1");
        lift_level.classList.remove("background_text2");
        circle_level.classList.remove("circle_background2");
      } else {
        lift_level.classList.remove("background_text1");
        circle_level.classList.remove("circle_background1");
        lift_level.classList.add("background_text2");
        circle_level.classList.add("circle_background2");
      }
    } else {
      lift_level.classList.remove("background_text1");
      circle_level.classList.remove("circle_background1");
      lift_level.classList.remove("background_text2");
      circle_level.classList.remove("circle_background2");
    }
  }
}

function updateUpStatus(id, maxLevel, upStatus) {
  for (i = 0; i < maxLevel; i++) {
    level = document.getElementById("upArrow_" + id + "_" + (i + 1));
    arrow_box = document.getElementById("arrowBox_" + id + "_" + (i + 1));
    if (level) {
      if (checkLevel(upStatus, i + 1)) {
        level.classList.add("arrow_after");
        arrow_box.classList.add("arrow-box_after");
      } else {
        level.style.backgroundColor = "transparent";
        level.classList.remove("arrow_after");
        arrow_box.classList.remove("arrow-box_after");
      }
    }
  }
}
function updateDownStatus(id, maxLevel, downStatus) {
  for (i = 0; i < maxLevel; i++) {
    level = document.getElementById("downArrow_" + id + "_" + (i + 1));
    arrow_box = document.getElementById("arrowBox_" + id + "_" + (i + 1));
    if (level) {
      if (checkLevel(downStatus, i + 1)) {
        level.classList.add("arrow_after");
        arrow_box.classList.add("arrow-box_after");
      } else {
        level.style.backgroundColor = "transparent";
        level.classList.remove("arrow_after");
        arrow_box.classList.remove("arrow-box_after");
      }
    }
  }
}

function updateCarStatus(id, maxLevel, carStatus) {
  for (i = 0; i < maxLevel; i++) {
    level = document.getElementById("car_" + id + "_" + (i + 1));
    if (level) {
      if (checkLevel(carStatus, i + 1)) {
        level.style.backgroundColor = "#57dba0";
        level.style.Color = "black";
        // level.classList.add("car_after");
      } else {
        level.style.backgroundColor = "#2B2C31";
        level.style.Color = "#white";
        // level.classList.remove("car_after");
      }
    }
  }
}

function updateConnectionStatus(id, maxLevel, carStatus) {
  for (i = 0; i < maxLevel; i++) {
    level = document.getElementById("car_" + id + "_" + (i + 1));
    if (checkLevel(carStatus, i + 1)) {
      level.style.backgroundColor = "#57dba0";
      level.style.Color = "black";
      // level.classList.add("car_after");
    } else {
      level.style.backgroundColor = "#2B2C31";
      level.style.Color = "#white";
      // level.classList.remove("car_after");
    }
  }
}

// วนลูปเพื่อหาทุก div ที่มี class .column_circle
document.querySelectorAll(".column_circle").forEach(function (column) {
  // หา div ที่มี class .outer_circle ทั้งหมดภายใน .column_circle
  let circles = column.querySelectorAll(".out_circle");

  // หา div ที่มี class .line ภายใน .column_circle
  let line = column.querySelector(".line");

  // หาความสูงรวมของวงกลมทั้งหมด
  let totalHeight = 0;
  circles.forEach(function (circle, index) {
    totalHeight += circle.offsetHeight; // ความสูงของแต่ละวงกลม

    if (index < circles.length - 1) {
      // ถ้าไม่ใช่วงกลมวงสุดท้าย
      totalHeight += parseFloat(window.getComputedStyle(circle).marginBottom); // ระยะห่างระหว่างวงกลม
    }
  });

  // กำหนดความสูงของเส้น line
  line.style.height = totalHeight + "px";
});

function checkLevel(statusString, level) {
  if (level <= 8) {
    value = parseInt(statusString.substring(0, 2), 16);
    mask = 1 << (level - 1);
    if ((value & mask) != 0) {
      return true;
    }
  } else if (level <= 16) {
    value = parseInt(statusString.substring(2, 4), 16);
    mask = 1 << (level - 9);
    if ((value & mask) != 0) {
      return true;
    }
  } else if (level <= 24) {
    value = parseInt(statusString.substring(4, 6), 16);
    mask = 1 << (level - 17);
    if ((value & mask) != 0) {
      return true;
    }
  } else {
    value = parseInt(statusString.substring(6, 8), 16);
    mask = 1 << (level - 25);
    if ((value & mask) != 0) {
      return true;
    }
  }
  return false;
}

// class LiftDoorApp {
//   constructor() {
//     throw new Error("This is a static class and should not be instantiated.");
//   }

//   static _kFontFam = "LiftDoorApp";
//   static _kFontPkg = null;

//   static closing = {
//     code: 0xe800,
//     fontFamily: LiftDoorApp._kFontFam,
//     fontPackage: LiftDoorApp._kFontPkg,
//   };
//   static opening = {
//     code: 0xe801,
//     fontFamily: LiftDoorApp._kFontFam,
//     fontPackage: LiftDoorApp._kFontPkg,
//   };
//   static open = {
//     code: 0xe802,
//     fontFamily: LiftDoorApp._kFontFam,
//     fontPackage: LiftDoorApp._kFontPkg,
//   };
//   static close = {
//     code: 0xe803,
//     fontFamily: LiftDoorApp._kFontFam,
//     fontPackage: LiftDoorApp._kFontPkg,
//   };
// }

// function checkDoorIcon(statusString) {
//   let value = parseInt(statusString.substring(2, 4), 16);
//   let doorStatus = value & 3;

//   if (doorStatus === 0) {
//     return LiftDoorApp.open.code;
//   } else if (doorStatus === 1) {
//     return LiftDoorApp.close.code;
//   } else if (doorStatus === 2) {
//     return LiftDoorApp.closing.code;
//   } else if (doorStatus === 3) {
//     return LiftDoorApp.opening.code;
//   } else {
//     return LiftDoorApp.open.code;
//   }
// }

function checkDoorText(statusString) {
  value = parseInt(statusString.substring(2, 4), 16);
  doorStatus = value & 3;
  if (doorStatus == 0) {
    return "Opened";
  } else if (doorStatus == 1) {
    return "Closed";
  } else if (doorStatus == 2) {
    return "Closing";
  } else if (doorStatus == 3) {
    return "Opening";
  } else {
    return "Opened";
  }
}

// let statusText = "";
// let statusClass = "";

// switch (doorStatus) {
//   case 0:
//     statusText = "Opened";
//     statusClass = "open_class";
//     break;
//   case 1:
//     statusText = "Closed";
//     statusClass = "close_class";
//     break;
//   case 2:
//     statusText = "Closing";
//     statusClass = "close_class";
//     break;
//   case 3:
//     statusText = "Opening";
//     statusClass = "open_class";
//     break;
//   default:
//     statusText = "Opened";
//     statusClass = "open_class";
//     break;
// }
// return {
//   text: statusText,
//   class: statusClass,
// };
// }

// const door = checkDoorText(statusString);

// const doorElement = document.getElementById("door_" + id + "_" + (i + 1));
// doorElement.textContent = door.text;
// doorElement.className = door.class;

function checkSpeed(statusString) {
  value = parseInt(statusString.substring(8, 12), 16);
  return parseInt(value / 100) / 10;
}

function checkError(statusString) {
  value = parseInt(statusString.substring(6, 8), 16);
  return value;
}

function checkWorkingStatus(statusString) {
  value = parseInt(statusString.substring(4, 6), 16);
  workingStatus = value & 15;
  if (workingStatus == 0) {
    return "Auto";
  } else if (workingStatus == 1) {
    return "INSP";
  } else if (workingStatus == 2) {
    return "Fire";
  } else if (workingStatus == 3) {
    return "Driving";
  } else if (workingStatus == 4) {
    return "Special";
  } else if (workingStatus == 5) {
    return "Learning";
  } else if (workingStatus == 6) {
    return "Lock";
  } else if (workingStatus == 7) {
    return "Reset";
  } else if (workingStatus == 8) {
    return "UPS";
  } else if (workingStatus == 9) {
    return "Idle";
  } else if (workingStatus == 10) {
    return "Break";
  } else if (workingStatus == 11) {
    return "Bypass";
  } else {
    return "Error";
  }
}
