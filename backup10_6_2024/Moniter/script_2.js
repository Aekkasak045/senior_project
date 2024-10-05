const datacontainer = document.getElementById("data-container");
const organization = document.getElementById("organization")
const building = document.getElementById("building")
const description = document.getElementById("description")

fetch("http://52.221.67.113/smartlift/Manage/Summary.php")
  //json decode Js_Obj
  .then(Response => Response.json())
  // input data
  .then(data => {
    const dataArray = Object.values(data);
    // ตรวจสอบผลลัพธ์
    // console.log(dataArray);
    // console.log(data)
    appendData(dataArray)
    if (Array.isArray(dataArray)) {
      // วนลูปผ่านข้อมูลผู้ใช้และสร้าง div แสดงข้อมูล
      dataArray.forEach((user) => {
        const userDiv = document.createElement("div");
        userDiv.innerHTML = `
                        org:  ${user.ORGANIZATIONS}
                        build:  ${user.BUILDING}
                        descript:  ${user.description}
                      `;
        // เพิ่ม div ของผู้ใช้ลงใน div หลัก
        organization.appendChild(userDiv);
      });
    } else {
      console.error("ข้อมูลไม่ใช่ array");
    }
  })
  .catch((error) => {
    console.error("เกิดข้อผิดพลาดในการดึงข้อมูล API", error);
  });
