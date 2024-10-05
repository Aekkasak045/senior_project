document.addEventListener("DOMContentLoaded", function () {
  const targetUrls = ["org_all.php", "building.php", "lifts.php"];
  const targetBuild = ["lift.html"];

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
