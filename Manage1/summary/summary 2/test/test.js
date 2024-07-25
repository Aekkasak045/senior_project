const ids = [1, 2, 3]; // คุณสามารถเพิ่ม id ได้ตามที่คุณต้องการ
const orgIds = [3, 4, 5]; // คุณสามารถเพิ่ม org_id ได้ตามที่คุณต้องการ

for (let i = 0; i < ids.length; i++) {
  let apiUrl = `http://52.221.67.113/smartlift/SUMMARY/get_Byid.php?id=${ids[i]}&org_id=${orgIds[i]}&api_key=Test%20api%20webs`;

  fetch(apiUrl)
    .then((response) => response.json())
    .then((data) => {
      let content = `
            <h2>Organization ID: ${data.organization_by_id.id}</h2>
            <p>Organization Name: ${data.organization_by_id.org_name}</p>
            <h3>Building Name: ${data.building.building_name}</h3>
            <h4>Lifts (${data.lifts_orgid_count}):</h4>
            <ul>
            `;

      for (let lift of data.lifts_by_orgid) {
        content += `<li>${lift}</li>`;
      }

      content += `</ul>`;
      document.getElementById("data-output").innerHTML += content;
    })
    .catch((error) => {
      console.error("Error fetching the API:", error);
    });
}
