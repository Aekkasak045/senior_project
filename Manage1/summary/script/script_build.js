document.addEventListener("DOMContentLoaded", function () {
  const targetUrls = ["org_all.html", "building.html", "lifts.html"];
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

      organizations_all(org_count, build_count, org_all);
    });
  // .catch((err) => {
  //   console.log("error: " + err);
  // });

  function building_all(build_count, build_count, org_all) {
    var description_orgs = document.getElementById("description_orgs");
    description_orgs.innerHTML =
      org_count + " ORGANIZATIONS " + build_count + " BUILDINGS";

    var orgs_all = document.getElementById("org_all");

    var orgs1 = document.createElement("div");
    orgs1.classList.add("box_data");
    orgs1.innerHTML = `<span>${org_all[0]}</span><span>${build_count} BUILDINGS</span>`;
    const orgs_link1 = document.createElement("a");
    orgs_link1.classList.add("link_page");
    orgs_link1.href = targetBuild[0];
    orgs_link1.appendChild(orgs1);
    orgs_all.appendChild(orgs_link1);

    var orgs2 = document.createElement("div");
    orgs2.classList.add("box_data");
    orgs2.innerHTML = `<span>${org_all[1]}</span><span>${build_count} BUILDINGS</span>`;
    const orgs_link2 = document.createElement("a");
    orgs_link2.classList.add("link_page");
    orgs_link2.href = targetBuild[0];
    orgs_link2.appendChild(orgs2);
    orgs_all.appendChild(orgs_link2);

    var orgs3 = document.createElement("div");
    orgs3.classList.add("box_data");
    orgs3.innerHTML = `<span>${org_all[2]}</span><span>${build_count} BUILDINGS</span>`;
    const orgs_link3 = document.createElement("a");
    orgs_link3.classList.add("link_page");
    orgs_link3.href = targetBuild[0];
    orgs_link3.appendChild(orgs3);
    orgs_all.appendChild(orgs_link3);
  }
});
