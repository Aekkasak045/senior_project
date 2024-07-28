<?php
    // คำสั่งแสดงสีหน้าตาราง เมื่อ role แสดงผลลัพธ์ที่แตกต่างกัน
    function role($row) {
        if ($row['role'] == "mainten") {
            return "<td class='td-status-Mainten'>" . "</td>";
        } elseif ($row["role"] == "admin") {
            return "<td class='td-status-Admin'>" . "</td>";
        } else {
            return "<td class='td-status-User'>" . "</td>";
        }
    }

    // คำสั่งแสดงผล role ให้อักษรตัวแรกเป็นตัวพิมพ์ใหญ่
    function show_role($row) {
        if ($row["role"] == "mainten")
            return "<td>Mainten</td>";
        elseif ($row["role"] == "admin")
            return "<td>Admin</td>";
        else
            return "<td>User</td>";
    }
?>