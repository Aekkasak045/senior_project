document.addEventListener("DOMContentLoaded", function () {
  const targetUrls = ["orgs_all.php"];

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
    });
  // .catch((err) => {
  //   console.log("error: " + err);
  // });

  function dataOverview(org_count) {
    var mainContent = document.getElementById("box-content");

    var orgs = document.createElement("div");
    orgs.classList.add("box_data");
    orgs.innerHTML = `<p>${org_count}</p><span>ORGANIZATIONS</span>`;
    const orgs_link = document.createElement("a");
    orgs_link.classList.add("link_page");
    orgs_link.href = targetUrls[0];
    orgs_link.appendChild(orgs);
    mainContent.appendChild(orgs_link);
  }
});

// function getData(liftId) {
//   let loadData = new XMLHttpRequest();
//   loadData.onreadystatechange = function () {
//     if (loadData.readyState === 4 && loadData.status === 200) {
//       let conn = JSON.parse(loadData.responseText);
//       let connectionStatus = conn.connection_status;
//       updateUI(liftId, connectionStatus);
//     }
//   };
//   loadData.open(
//     "GET",
//     "http://52.221.67.113/smartlift/get_status.php?lift_id=" + liftId,
//     true
//   );
//   loadData.send();
// }

function getData(liftId) {
  fetch("http://52.221.67.113/smartlift/get_status.php?lift_id=" + liftId)
    .then((response) => response.json())
    .then((conn) => {
      let connectionStatus = conn.connection_status;
      updateUI(liftId, connectionStatus);
    })
    .catch((error) => console.error("Error fetching data:", error));
}

function updateUI(liftId, connectionStatus) {
  updateConnectionStatus(liftId, connectionStatus);
}

function updateConnectionStatus(liftId, connectionStatus) {
  let connectionElement = document.getElementById("lift_status_" + liftId);
  if (connectionElement) {
    connectionElement.textContent = connectionStatus;
    if (connectionStatus === "Offline") {
      connectionElement.classList.add("conn_after1");
      connectionElement.classList.remove("conn_after2");
    } else {
      connectionElement.classList.remove("conn_after1");
      connectionElement.classList.add("conn_after2");
    }
  }
}
