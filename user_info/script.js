
    $(document).ready(function () {

        $('.editbtn').on('click', function () {

            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);
            $('#id').val(data[0]);
            $('#username').val(data[1]);
            $('#password').val(data[2]);
            $('#first_name').val(data[3]);
            $('#last_name').val(data[4]);
            $('#email').val(data[5]);
            $('#phone').val(data[6]);
            $('#bd').val(data[7]);
            $('#role').val(data[8]);
        });
    });


    $(document).ready(function(){
        $('#search_text').on("keyup", function(){
          var search_text = $(this).val();
          $.ajax({
            method:'POST',
            url:'user_search.php',
            data:{search:search_text},
            success:function(response)
            {
                 $("#showdata").html(response);
            } 
          });
        });
       });


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