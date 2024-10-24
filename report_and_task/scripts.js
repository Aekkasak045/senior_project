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


$(document).ready(function () {
  $("#addProblemBtn").click(function (e) {
      e.preventDefault(); // ป้องกันการส่งฟอร์มแบบดั้งเดิม

      var new_problem = $("#new_problem").val(); // รับค่าจากฟิลด์ป้อนข้อมูล

      if (new_problem !== "") {
          $.ajax({
              url: "add_problem.php", // ไฟล์ PHP ที่ใช้ในการบันทึกข้อมูล
              type: "POST",
              data: {
                  new_problem: new_problem
              },
              success: function (response) {
                  alert("New problem added successfully");
                  // อัปเดตรายการปัญหาทันทีโดยไม่ต้องโหลดหน้าใหม่
                  $("#problemList").append('<li class="list-group-item">' + new_problem + '</li>');
                  $("#new_problem").val(""); // ล้างฟิลด์ป้อนข้อมูลหลังบันทึก
              },
              error: function () {
                  alert("Error occurred while adding problem.");
              }
          });
      } else {
          alert("Please enter a problem name.");
      }
  });
});