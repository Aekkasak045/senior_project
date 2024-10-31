//เปิด-ปิด popup ของ filter
function openPop() {
  const popDialog =
      document.getElementById(
          "popupDialog"
      );
  popDialog.style.visibility =
      popDialog.style.visibility ===
      "visible"
          ? "hidden"
          : "visible";
}

function updateTaskStatus() {
// ใช้ AJAX เพื่อเรียกไฟล์ PHP
var xhr = new XMLHttpRequest();
xhr.open("GET", "update_task_status.php", true);
xhr.onreadystatechange = function () {
    if (xhr.readyState == 5 && xhr.status == 200) {
        document.getElementById("status-message").innerHTML = xhr.responseText;
    }
};
xhr.send();
}

// เรียกใช้ฟังก์ชัน updateTaskStatus ทุก 10 วินาที (10000 มิลลิวินาที)
setInterval(updateTaskStatus, 10000);

// เรียกใช้ครั้งแรกทันทีเมื่อโหลดหน้าเว็บ
updateTaskStatus();

//live search สำหรับหน้า report
$(document).ready(function(){
$('#search_report').on("keyup", function(){
  var search_report = $(this).val();
  $.ajax({
    method:'POST',
    url:'report_search.php',
    data:{search:search_report},
    success:function(response)
    {
         $("#showdata").html(response);
    } 
  });
});
});

//live search สำหรับหน้า task
$(document).ready(function(){
$('#search_task').on("keyup", function(){
  var search_task = $(this).val();
  $.ajax({
    method:'POST',
    url:'task_search.php',
    data:{search:search_task},
    success:function(response)
    {
         $("#showdata").html(response);
    } 
  });
});
});

function validateForm() {
var startDate = document.getElementById("task_start_date").value;
var currentDate = new Date().toISOString().slice(0, 16);

if (startDate < currentDate) {
    alert("กรุณาเลือกวันที่และเวลาเริ่มงานที่ถูกต้อง");
    return false; // หยุดการส่งฟอร์ม
}

return true; // ส่งฟอร์มถ้าข้อมูลถูกต้อง
}

function openProblemPopup() {
  document.getElementById("problemPopup").style.display = "block";
}

function closeProblemPopup() {
  document.getElementById("problemPopup").style.display = "none";
}


 // ฟังก์ชันสำหรับเปิดป๊อปอัป
 function openResultsPopup() {
  document.getElementById("resultsPopup").style.display = "block";
  loadFilters(); // โหลดตัวเลือกปีและลิฟต์เมื่อเปิดป๊อปอัป
}

// ฟังก์ชันสำหรับปิดป๊อปอัป
function closeResultsPopup() {
  document.getElementById("resultsPopup").style.display = "none";
}


// ฟังก์ชันสำหรับเปิดป๊อปอัปและโหลดตัวเลือก
function openResultsPopup() {
  document.getElementById("resultsPopup").style.display = "block";
  loadFilters(); // โหลดตัวเลือกเมื่อเปิดป๊อปอัป
}

// ฟังก์ชันสำหรับปิดป๊อปอัป
function closeResultsPopup() {
  document.getElementById("resultsPopup").style.display = "none";
}

function loadChartData() {
  console.log("loadChartData ถูกเรียกใช้งาน");

  var selectedYear = document.getElementById('yearSelect').value;
  var selectedLift = document.getElementById('liftSelect').value;

  $.ajax({
      url: 'get_task_data.php',
      method: 'GET',
      data: {
          year: selectedYear,
          lift_id: selectedLift
      },
      success: function(data) {
          console.log("Raw data from server: ", data); // ตรวจสอบข้อมูลที่ได้รับจากเซิร์ฟเวอร์
          
          try {
              if (typeof data === "string") {
                  data = JSON.parse(data);  // แปลงเป็น JSON ถ้าจำเป็น
              }
              console.log("Parsed data: ", data);

              // ตรวจสอบว่าข้อมูล JSON ถูกต้อง
              if (data.problems && data.problem_counts) {
                  // สร้างกราฟใหม่ทุกครั้งที่มีการเปลี่ยนแปลง
                  updatePieChart(data); // เรียกฟังก์ชันที่อัปเดตกราฟ
              } else {
                  console.error("JSON ไม่ถูกต้องหรือข้อมูลไม่ครบถ้วน");
              }

          } catch (error) {
              console.error("Error parsing JSON: ", error);
              console.log("Response received: ", data);
          }
      },
      error: function(xhr, status, error) {
          console.error("Error loading chart data: " + error);
      }
  });
}

// ฟังก์ชันสำหรับอัปเดตแผนภูมิวงกลม
let taskChart; // เก็บข้อมูลของแผนภูมิ

function updatePieChart(data) {
  // ตรวจสอบว่ามีกราฟอยู่แล้วหรือไม่ ถ้ามีก็ลบออกก่อน
  if (taskChart) {
      taskChart.destroy();
  }

  var ctx = document.getElementById('taskChart').getContext('2d');
  taskChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: data.problems, // รายชื่อปัญหา
          datasets: [{
              label: 'จำนวนครั้งของปัญหา',
              data: data.problem_counts, // จำนวนปัญหา
              backgroundColor: [
                  'rgba(255, 99, 132, 0.6)',
                  'rgba(54, 162, 235, 0.6)',
                  'rgba(255, 206, 86, 0.6)',
                  'rgba(75, 192, 192, 0.6)',
                  'rgba(153, 102, 255, 0.6)',
                  'rgba(255, 159, 64, 0.6)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: {
                  position: 'top',
              }
          }
      }
  });
}

// เรียกใช้ฟังก์ชันโหลดข้อมูลเมื่อผู้ใช้เปลี่ยนปีหรือลิฟต์
document.getElementById('yearSelect').addEventListener('change', loadChartData);
document.getElementById('liftSelect').addEventListener('change', loadChartData);

function createPieChart(data) {
  if (taskChart) {
      taskChart.destroy(); // ลบกราฟเก่า
  }

  var ctx = document.getElementById('taskChart').getContext('2d');
  
  // สร้างกราฟวงกลม
  taskChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: data.problems, // รายชื่อปัญหา
          datasets: [{
              label: 'จำนวนครั้งของปัญหา',
              data: data.problem_counts, // จำนวนปัญหา
              backgroundColor: [
                  'rgba(255, 99, 132, 0.6)',
                  'rgba(54, 162, 235, 0.6)',
                  'rgba(255, 206, 86, 0.6)',
                  'rgba(75, 192, 192, 0.6)',
                  'rgba(153, 102, 255, 0.6)',
                  'rgba(255, 159, 64, 0.6)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true, // ทำให้ขนาดของกราฟตอบสนองกับหน้าจอ
          maintainAspectRatio: false, // ปิดการคงอัตราส่วน
          plugins: {
              legend: {
                  position: 'top',
              },
              tooltip: {
                  callbacks: {
                      label: function(context) {
                          var label = context.label || '';
                          var value = context.raw || 0;
                          return label + ': ' + value + ' ครั้ง';
                      }
                  }
              }
          }
      }
  });
}



function loadFilters() {
  $.ajax({
      url: 'get_filters.php',
      method: 'GET',
      success: function(data) {
          try {
              var filters = JSON.parse(data);
              console.log(filters); // แสดงข้อมูลที่ได้เพื่อการดีบัก

              var yearSelect = document.getElementById('yearSelect');
              yearSelect.innerHTML = '<option value="">Select Year</option>';
              filters.years.forEach(function(year) {
                  var option = document.createElement('option');
                  option.value = year;
                  option.text = year;
                  yearSelect.add(option);
              });

              var liftSelect = document.getElementById('liftSelect');
              liftSelect.innerHTML = '<option value="">Select Lift</option>';
              filters.lifts.forEach(function(lift) {
                  var option = document.createElement('option');
                  option.value = lift;
                  option.text = lift;
                  liftSelect.add(option);
              });
          } catch (error) {
              console.error("Error parsing JSON: ", error);
              console.log("Response received: ", data);
          }
      },
      error: function(xhr, status, error) {
          console.error("Error fetching filters: " + error);
      }
  });
  
}


