const targetBuild = ["lift.html"];

fetch(
  "http://52.221.67.113/smartlift/SUMMARY/get_summary.php?api_key=sum%20ma%20ry"
)
  .then((Response) => Response.json())
  .then((data1) => {
    org_count = data1.organizations_count;
    build_count = data1.Building_count;
    lifts_count = data1.lifts_count;
    org_all = data1.organizations_all;
    build_all = data1.Building_all;
    lifts_all = data1.lifts_all;

    organizations_head(org_count, build_count);
  });
// .catch((err) => {
//   console.log("error: " + err);
// });

fetch(
  "http://52.221.67.113/smartlift/SUMMARY/get_Byid.php?id=1&org_id=1&api_key=Test%20api%20webs"
)
  .then((Response) => Response.json())
  .then((data) => {
    orgID_count = data.organization_byid_count;
    org_id = data.organization_by_id;
    org_name = data.organization_by_id.org_name;
    build_name_str = data.building.building_name;
    liftID_count = data.lifts_orgid_count;
    lift_id = data.lifts_by_orgid;

    build_name_arr = build_name_str.split(", ");
    build_count_id = build_name_arr.length;
    organizations_all(org_name, build_count_id);
  });
// .catch((err) => {
//   console.log("error: " + err);
// });

function organizations_head(org_count, build_count) {
  var description_orgs = document.getElementById("description_orgs");
  description_orgs.innerHTML =
    org_count + " ORGANIZATIONS " + build_count + " BUILDINGS";
}

function organizations_all(org_name, build_count_id) {
  var orgs_all = document.getElementById("org_all");

  var orgs1 = document.createElement("div");
  orgs1.classList.add("box_data");
  orgs1.innerHTML = `<span>${org_name}</span><span>${build_count_id} BUILDINGS</span>`;
  const orgs_link1 = document.createElement("a");
  orgs_link1.classList.add("link_page");
  orgs_link1.href = targetBuild[0];
  orgs_link1.appendChild(orgs1);
  orgs_all.appendChild(orgs_link1);
}
fetch(
  "http://52.221.67.113/smartlift/SUMMARY/get_Byid.php?id=1&org_id=1&api_key=Test%20api%20webs"
)
  .then((Response) => Response.json())
  .then((data) => {
    orgID_count = data.organization_byid_count;
    org_id = data.organization_by_id;
    org_name = data.organization_by_id.org_name;
    build_name_str = data.building.building_name;
    liftID_count = data.lifts_orgid_count;
    lift_id = data.lifts_by_orgid;

    build_name_arr = build_name_str.split(", ");
    build_count_id = build_name_arr.length;
    organizations_all(org_name, build_count_id);
  });
// .catch((err) => {
//   console.log("error: " + err);
// });

function organizations_head(org_count, build_count) {
  var description_orgs = document.getElementById("description_orgs");
  description_orgs.innerHTML =
    org_count + " ORGANIZATIONS " + build_count + " BUILDINGS";
}

function organizations_all(org_name, build_count_id) {
  var orgs_all = document.getElementById("org_all");

  var orgs1 = document.createElement("div");
  orgs1.classList.add("box_data");
  orgs1.innerHTML = `<span>${org_name}</span><span>${build_count_id} BUILDINGS</span>`;
  const orgs_link1 = document.createElement("a");
  orgs_link1.classList.add("link_page");
  orgs_link1.href = targetBuild[0];
  orgs_link1.appendChild(orgs1);
  orgs_all.appendChild(orgs_link1);
}
fetch(
  "http://52.221.67.113/smartlift/SUMMARY/get_Byid.php?id=1&org_id=1&api_key=Test%20api%20webs"
)
  .then((Response) => Response.json())
  .then((data) => {
    orgID_count = data.organization_byid_count;
    org_id = data.organization_by_id;
    org_name = data.organization_by_id.org_name;
    build_name_str = data.building.building_name;
    liftID_count = data.lifts_orgid_count;
    lift_id = data.lifts_by_orgid;

    build_name_arr = build_name_str.split(", ");
    build_count_id = build_name_arr.length;
    organizations_all(org_name, build_count_id);
  });
// .catch((err) => {
//   console.log("error: " + err);
// });

function organizations_head(org_count, build_count) {
  var description_orgs = document.getElementById("description_orgs");
  description_orgs.innerHTML =
    org_count + " ORGANIZATIONS " + build_count + " BUILDINGS";
}

function organizations_all(org_name, build_count_id) {
  var orgs_all = document.getElementById("org_all");

  var orgs1 = document.createElement("div");
  orgs1.classList.add("box_data");
  orgs1.innerHTML = `<span>${org_name}</span><span>${build_count_id} BUILDINGS</span>`;
  const orgs_link1 = document.createElement("a");
  orgs_link1.classList.add("link_page");
  orgs_link1.href = targetBuild[0];
  orgs_link1.appendChild(orgs1);
  orgs_all.appendChild(orgs_link1);
}
