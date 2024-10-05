document.addEventListener("DOMContentLoaded", function () {
  const targetUrls = ["orgs_all.php", "buildings.php", "lifts.php"];

  fetch(
    "http://52.221.67.113/smartlift/SUMMARY/get_summary.php?api_key=sum%20ma%20ry"
  )
    .then((Response) => Response.json())
    .then((data) => {
      org_count = data.organizations_count;
      build_count = data.Building_count;
      lifts_count = data.lifts_count;
      org_all = data.organizations_all;
      build_all = data.Building_all;
      lifts_all = data.lifts_all;

      dataOverview(org_count, build_count, lifts_count);
      organizations_all(org_count, build_count, org_all);
    });
  // .catch((err) => {
  //   console.log("error: " + err);
  // });

  function dataOverview(org_count, build_count, lifts_count) {
    var mainContent = document.getElementById("box-content");

    var orgs = document.createElement("div");
    orgs.classList.add("box_data");
    orgs.innerHTML = `<p>${org_count}</p><span>ORGANIZATIONS</span>`;
    const orgs_link = document.createElement("a");
    orgs_link.classList.add("link_page");
    orgs_link.href = targetUrls[0];
    orgs_link.appendChild(orgs);
    mainContent.appendChild(orgs_link);

    var builds = document.createElement("div");
    builds.classList.add("box_data");
    builds.innerHTML = `<p>${build_count}</p><span>BUILDINGS</span>`;
    const builds_link = document.createElement("a");
    builds_link.classList.add("link_page");
    builds_link.href = targetUrls[1];
    builds_link.appendChild(builds);
    mainContent.appendChild(builds_link);

    var lifts = document.createElement("div");
    lifts.classList.add("box_data");
    lifts.innerHTML = `<p>${lifts_count}</p><span>ELEVATORS</span>`;
    const lifts_link = document.createElement("a");
    lifts_link.classList.add("link_page");
    lifts_link.href = targetUrls[2];
    lifts_link.appendChild(lifts);
    mainContent.appendChild(lifts_link);
  }
});

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
  door = document.getElementById("door_" + id);
  mode = document.getElementById("mode_" + id);
  connection = document.getElementById("connection_" + id);
  door.innerHTML = checkDoorText(liftState);
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
      } else {
        level.style.backgroundColor = "#2B2C31";
        level.style.Color = "#white";
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
    } else {
      level.style.backgroundColor = "#2B2C31";
      level.style.Color = "#white";
    }
  }
}

document.querySelectorAll(".column_circle").forEach(function (column) {
  let circles = column.querySelectorAll(".out_circle");

  let line = column.querySelector(".line");

  let totalHeight = 0;
  circles.forEach(function (circle, index) {
    totalHeight += circle.offsetHeight;

    if (index < circles.length - 1) {
      totalHeight += parseFloat(window.getComputedStyle(circle).marginBottom);
    }
  });

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
