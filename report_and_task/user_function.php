<?php
    // การแสดงผล status ของ task
    function show_task_status($row) {
        if ($row["tk_status"] == 1)
            return "<td>มอบหมาย</td>";
        elseif ($row["tk_status"] == 2)
            return "<td>กำลังเตรียมอุปกรณ์</td>";
        elseif ($row["tk_status"] == 3)
            return "<td>เตรียมอุปกรณ์เสร็จสิ้น</td>";
        elseif ($row["tk_status"] == 4)
            return "<td>กำลังดำเนินการ</td>";
        else
            return "<td>ดำเนินการเสร็จสิ้น</td>";
    }

    function status($row) {
        if ($row['tk_status'] == 1) {
            return "<td class='td-status-1'>" . "</td>";
        } elseif ($row['tk_status'] == 2) {
            return "<td class='td-status-2'>" . "</td>";
        }elseif ($row['tk_status'] == 3) {
            return "<td class='td-status-3'>" . "</td>";
        }elseif ($row['tk_status'] == 4) {
            return "<td class='td-status-4'>" . "</td>";
        } else {
            return "<td class='td-status-5'>" . "</td>";
        }
    }

    // filter ของหน้า Report Information
    function filter_report() {
        $lift = "";
        $option = "";
        $date = "";
        $id_min = "(rp_id >='".$_POST['id_min']."')";
        $id_max = "(rp_id <='".$_POST['id_max']."')";
        $id= "((rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
        $bd_min = "(report.date_rp >='".$_POST['bd_min']."')";
        $bd_max = "(report.date_rp <='".$_POST['bd_max']."')";
        $bd= "((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."'))";

        // ตรวจสอบการเรียงลำดับ
        if (isset($_POST["id"])) {
            if ($_POST["id"] == "Lowest_to_Highest") {
                $option = "ORDER BY report.rp_id ASC"; // เรียงจากน้อยไปมาก
            } else {
                $option = "ORDER BY report.rp_id DESC"; // เรียงจากมากไปน้อย
            }
        }else{
            $option = "ORDER BY report.rp_id DESC"; // เรียงจากมากไปน้อย
        }
    
        // ตรวจสอบที่อยู่ลิฟต์
        if (isset($_POST["position"])) {
            if (isset($_POST["org_name"])&&$_POST["org_name"]!="") {
                // หากเลือกองค์กร
                $lift = "organizations.org_name = '" .$_POST["org_name"]. "'";
            } elseif (isset($_POST["building_name"])&&$_POST["building_name"]!="") {
                // หากเลือกอาคาร
                $lift = "building.building_name = '" .$_POST["building_name"] . "'";
            } elseif (isset($_POST["lift_name"])&&$_POST["lift_name"]!="") {
                // หากเลือกลิฟท์
                $lift = "lifts.lift_name = '" .$_POST["lift_name"] . "'";
            } else{
                $lift = "(organizations.org_name=1 OR 1=1)"; // ค้นหาทุกแถว
            }
        }else{
            $lift = "(organizations.org_name=1 OR 1=1)"; // ค้นหาทุกแถว
        }

        if (isset($_POST["bd_min"])&&isset($_POST["bd_max"])) {
            if ($_POST["bd_min"] == ""&&$_POST["bd_max"]==""){
                if (isset($_POST["id_min"])&&isset($_POST["id_max"])) {
                    if ($_POST["id_min"] == ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $lift . " " . $option."";
                    } elseif ($_POST["id_min"] != ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $id_min . " AND " . $lift . " " . $option."";
                    }elseif ($_POST["id_min"] == ""&&$_POST["id_max"]!=""){
                        $date = "WHERE " . $id_max . " AND " . $lift . " " . $option."";
                    }else{
                        $date = "WHERE " . $id . " AND " . $lift . " " . $option."";
                    }
                }
            } elseif ($_POST["bd_min"] != ""&&$_POST["bd_max"]==""){
                if (isset($_POST["id_min"])&&isset($_POST["id_max"])) {
                    if ($_POST["id_min"] == ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $bd_min . " AND " . $lift . " " . $option."";
                    } elseif ($_POST["id_min"] != ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $bd_min . " AND " . $id_min . " AND " . $lift . " " . $option."";
                    }elseif ($_POST["id_min"] == ""&&$_POST["id_max"]!=""){
                        $date = "WHERE " . $bd_min . " AND " . $id_max . " AND " . $lift . " " . $option."";
                    }else{
                        $date = "WHERE " . $bd_min . " AND " . $id . " AND " . $lift . " " . $option."";
                    }
                }
            } elseif ($_POST["bd_min"] == ""&&$_POST["bd_max"]!=""){
                if (isset($_POST["id_min"])&&isset($_POST["id_max"])) {
                    if ($_POST["id_min"] == ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $bd_max . " AND " . $lift . " " . $option."";
                    } elseif ($_POST["id_min"] != ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $bd_max . " AND " . $id_min . " AND " . $lift . " " . $option."";
                    }elseif ($_POST["id_min"] == ""&&$_POST["id_max"]!=""){
                        $date = "WHERE " . $bd_max . " AND " . $id_max . " AND " . $lift . " " . $option."";
                    }else{
                        $date = "WHERE " . $bd_max . " AND " . $id . " AND " . $lift . " " . $option."";
                    }
                }
            } else{
                if (isset($_POST["id_min"])&&isset($_POST["id_max"])) {
                    if ($_POST["id_min"] == ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $bd . " AND " . $lift . " " . $option."";
                    } elseif ($_POST["id_min"] != ""&&$_POST["id_max"]==""){
                        $date = "WHERE " . $bd . " AND " . $id_min . " AND " . $lift . " " . $option."";
                    }elseif ($_POST["id_min"] == ""&&$_POST["id_max"]!=""){
                        $date = "WHERE " . $bd . " AND " . $id_max . " AND " . $lift . " " . $option."";
                    }else{
                        $date = "WHERE " . $bd . " AND " . $id . " AND " . $lift . " " . $option."";
                    }
                }
            }
            $sql = "SELECT report.rp_id,report.detail,report.date_rp,
                                users.first_name,organizations.org_name,
                                building.building_name,lifts.lift_name 
                                FROM report 
                                INNER JOIN users ON report.user_id = users.id 
                                INNER JOIN organizations ON report.org_id = organizations.id 
                                INNER JOIN building ON organizations.id = building.id 
                                INNER JOIN lifts ON report.lift_id = lifts.id 
                                $date";
                    return $sql;
        }
    }

    // filter ของหน้า Task Information
    function filter_task() {
        $lift = "";
        $option = "";
        $status = "";

        // ตรวจสอบการเรียงลำดับ
        if (isset($_POST["id"])) {
            if ($_POST["id"] == "Lowest_to_Highest") {
                $option = "ORDER BY task.tk_id ASC"; // เรียงจากน้อยไปมาก
            } else {
                $option = "ORDER BY task.tk_id DESC"; // เรียงจากมากไปน้อย
            }
        }else{
            $option = "ORDER BY task.tk_id DESC"; // เรียงจากมากไปน้อย
        }
    
        // ตรวจสอบที่อยู่ลิฟต์
        if (isset($_POST["position"])) {
            if (isset($_POST["org_name"])&&$_POST["org_name"]!="") {
                // หากเลือกองค์กร
                $lift = "task.org_name = '" .$_POST["org_name"]. "'";
            } elseif (isset($_POST["building_name"])&&$_POST["building_name"]!="") {
                // หากเลือกอาคาร
                $lift = "task.building_name = '" .$_POST["building_name"] . "'";
            } elseif (isset($_POST["lift_name"])&&$_POST["lift_name"]!="") {
                // หากเลือกลิฟท์
                $lift = "task.lift_id = '" .$_POST["lift_name"] . "'";
            } else{
                $lift = "(task.org_name=1 OR 1=1)"; // ค้นหาทุกแถว
            }
        }else{
            $lift = "(task.org_name=1 OR 1=1)"; // ค้นหาทุกแถว
        }

        //ตรวจสอบสถานะการทำงาน
        if (isset($_POST["status"])&&($_POST["status"]!="")) {
                // หากเลือกองค์กร
                $status = "task.tk_status = '".$_POST["status"]."'";
        }else{
            $status = "(task.tk_status=6 OR 1=1)"; // ค้นหาทุกแถว
        }
    
        if (isset($_POST["id_min"]) && isset($_POST["id_max"])) {
            if ($_POST["id_min"] == "" && $_POST["id_max"] == "") { // ไม่ใส่ id
                    $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                    users.first_name AS engineer_first_name,
                                    users.last_name AS engineer_last_name, 
                                    task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE " . $lift . " AND " . $status . " " . $option . "";
                    return $sql;
            }elseif ($_POST["id_min"] != "" && $_POST["id_max"] == "") { // ใส่ id น้อย
                $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                users.first_name AS engineer_first_name,
                                users.last_name AS engineer_last_name, 
                                task.org_name, task.building_name, task.lift_id, task.tools
                        FROM task
                        INNER JOIN users ON task.mainten_id = users.id
                        WHERE (task.tk_id>='".$_POST["id_min"]."') AND " . $lift . " AND " . $status . " " . $option . "";
                return $sql;
            }elseif ($_POST["id_min"] == "" && $_POST["id_max"] != "") { // ใส่ id มาก
                $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                users.first_name AS engineer_first_name,
                                users.last_name AS engineer_last_name, 
                                task.org_name, task.building_name, task.lift_id, task.tools
                        FROM task
                        INNER JOIN users ON task.mainten_id = users.id
                        WHERE (task.tk_id<='".$_POST["id_max"]."') AND " . $lift . " AND " . $status . " " . $option . "";
                return $sql;
            }else{ // ใส่ id ทั้งคู่
                $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                users.first_name AS engineer_first_name,
                                users.last_name AS engineer_last_name, 
                                task.org_name, task.building_name, task.lift_id, task.tools
                        FROM task
                        INNER JOIN users ON task.mainten_id = users.id
                        WHERE ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) AND " . $lift . " AND " . $status . " " . $option . "";
                return $sql;
            }
        }
    }
