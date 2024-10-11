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
      if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("status-message").innerHTML = xhr.responseText;
      }
  };
  xhr.send();
}

// เรียกใช้ฟังก์ชัน updateTaskStatus ทุก 10 วินาที (10000 มิลลิวินาที)
setInterval(updateTaskStatus, 10000);

// เรียกใช้ครั้งแรกทันทีเมื่อโหลดหน้าเว็บ
updateTaskStatus();

//live search สำหรับหน้า tool
$(document).ready(function(){
  $('#search_tool').on("keyup", function(){
    var search_report = $(this).val();
    $.ajax({
      method:'POST',
      url:'tool_search.php',
      data:{search:search_report},
      success:function(response)
      {
           $("#showdata").html(response);
      } 
    });
  });
 });




