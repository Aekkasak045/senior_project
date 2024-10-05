<?php
    // การแสดงผล status ของ task
    function show_task_status($row) {
        if ($row["tk_status"] == 1)
            return "<td>มอบหมาย</td>";
        elseif ($row["tk_status"] == 2)
            return "<td>รอดำเนินการ</td>";
        elseif ($row["tk_status"] == 3)
            return "<td>กำลังดำเนินการ</td>";
        else
            return "<td>ดำเนินการเสร็จสิ้น</td>";
    }

    // filter ของหน้า Report Information
    function filter_report() {
        if (isset($_POST["bd_min"])&&isset($_POST["bd_max"])) {
            if ($_POST["bd_min"] == ""&&$_POST["bd_max"]=="") {//ไม่ใส่ Birthday
                if(isset($_POST["id"])&&($_POST["id"]=="Lowest_to_Highest")){//เรียงจากน้อยไปมาก
                    if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                        if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id>='".$_POST["id_min"]."')
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id<='".$_POST["id_max"]."')
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }else{//ใส่ id ทั้งคู่
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }
                    }
                }else{//เรียงจากมากไปน้อย
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id>='".$_POST["id_min"]."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id<='".$_POST["id_max"]."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }
                        }
                }
            }if ($_POST["bd_min"] != ""&&$_POST["bd_max"]=="") {//ใส่ Birthday น้อยแต่ไม่ใส่มาก
                if(isset($_POST["id"])&&($_POST["id"]=="Lowest_to_Highest")){//เรียงจากน้อยไปมาก
                    if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                        if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (report.date_rp>='".$_POST["bd_min"]."') 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id>='".$_POST["id_min"]."')
                                    AND (report.date_rp>='".$_POST["bd_min"]."') 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id<='".$_POST["id_max"]."')
                                    AND (report.date_rp>='".$_POST["bd_min"]."')
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }else{//ใส่ id ทั้งคู่
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                    AND (report.date_rp>='".$_POST["bd_min"]."')
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }
                    }
                }else{//เรียงจากมากไปน้อย
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (report.date_rp>='".$_POST["bd_min"]."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id>='".$_POST["id_min"]."')
                                        AND (report.date_rp>='".$_POST["bd_min"]."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id<='".$_POST["id_max"]."')
                                        AND (report.date_rp>='".$_POST["bd_min"]."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                        AND (report.date_rp>='".$_POST["bd_min"]."')
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }
                        }
                }
            }if ($_POST["bd_min"] == ""&&$_POST["bd_max"]!="") {//ใส่ Birthday มากแต่ไม่ใส่น้อย
                if(isset($_POST["id"])&&($_POST["id"]=="Lowest_to_Highest")){//เรียงจากน้อยไปมาก
                    if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                        if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (report.date_rp<='".$_POST["bd_max"]."') 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id>='".$_POST["id_min"]."')
                                    AND (report.date_rp<='".$_POST["bd_max"]."') 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id<='".$_POST["id_max"]."')
                                    AND (report.date_rp<='".$_POST["bd_max"]."') 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }else{//ใส่ id ทั้งคู่
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                    AND (report.date_rp<='".$_POST["bd_max"]."') 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }
                    }
                }else{//เรียงจากมากไปน้อย
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (report.date_rp<='".$_POST["bd_max"]."') 
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id>='".$_POST["id_min"]."')
                                        AND (report.date_rp<='".$_POST["bd_max"]."') 
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id<='".$_POST["id_max"]."')
                                        AND (report.date_rp<='".$_POST["bd_max"]."') 
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                        AND (report.date_rp<='".$_POST["bd_max"]."') 
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }
                        }
                }
            }else{//ใส่ Birthday ทั้งคู่
                if(isset($_POST["id"])&&($_POST["id"]=="Lowest_to_Highest")){//เรียงจากน้อยไปมาก
                    if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                        if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id>='".$_POST["id_min"]."')
                                    AND ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) 
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id<='".$_POST["id_max"]."')
                                    AND ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."'))  
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }else{//ใส่ id ทั้งคู่
                            $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                    FROM report 
                                    INNER JOIN users ON report.user_id = users.id 
                                    INNER JOIN organizations ON report.org_id = organizations.id
                                    INNER JOIN lifts ON report.lift_id = lifts.id
                                    WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                    AND ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."'))  
                                    ORDER BY rp_id ASC;";
                            return $sql;
                        }
                    }
                }else{//เรียงจากมากไปน้อย
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) 
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id>='".$_POST["id_min"]."')
                                        AND ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."'))  
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id<='".$_POST["id_max"]."')
                                        AND ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."'))  
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT report.rp_id,report.detail,report.date_rp,users.first_name,organizations.org_name,lifts.lift_name 
                                        FROM report 
                                        INNER JOIN users ON report.user_id = users.id 
                                        INNER JOIN organizations ON report.org_id = organizations.id
                                        INNER JOIN lifts ON report.lift_id = lifts.id
                                        WHERE (rp_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (rp_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')
                                        AND ((report.date_rp BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (report.date_rp BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."'))
                                        ORDER BY rp_id DESC;";
                                return $sql;
                            }
                        }
                }
            }
        }
    }

    // filter ของหน้า Task Information
    function filter_task() {
        if (isset($_POST["id_min"]) && isset($_POST["id_max"])) {
            if ($_POST["id_min"] == "" && $_POST["id_max"] == "") { // ไม่ใส่ id
                if (isset($_POST["id"]) && $_POST["id"] == "Lowest_to_Highest") { // เรียงจากน้อยไปมาก
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            ORDER BY task.tk_id ASC";
                        return $sql;
                    }
                }else{//เรียงจากมากไปน้อย
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            ORDER BY task.tk_id DESC";
                        return $sql;
                    }
                }
            }if ($_POST["id_min"] != "" && $_POST["id_max"] == "") { // ใส่ id น้อยไม่ใส่มาก
                if (isset($_POST["id"]) && $_POST["id"] == "Lowest_to_Highest") { // เรียงจากน้อยไปมาก
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0 AND (task.tk_id>='".$_POST["id_min"]."')
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1 AND (task.tk_id>='".$_POST["id_min"]."')
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2 AND (task.tk_id>='".$_POST["id_min"]."')
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE (task.tk_id>='".$_POST["id_min"]."')
                            ORDER BY task.tk_id ASC";
                        return $sql;
                    }
                }else{//เรียงจากมากไปน้อย
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0 AND (task.tk_id>='".$_POST["id_min"]."')
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1 AND (task.tk_id>='".$_POST["id_min"]."')
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2 AND (task.tk_id>='".$_POST["id_min"]."')
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE (task.tk_id>='".$_POST["id_min"]."')
                            ORDER BY task.tk_id DESC";
                        return $sql;
                    }
                }
            }if ($_POST["id_min"] == "" && $_POST["id_max"] != "") { // ใส่ id มากไม่ใส่น้อย
                if (isset($_POST["id"]) && $_POST["id"] == "Lowest_to_Highest") { // เรียงจากน้อยไปมาก
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0 AND (task.tk_id<='".$_POST["id_max"]."')
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1 AND (task.tk_id<='".$_POST["id_max"]."')
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2 AND (task.tk_id<='".$_POST["id_max"]."')
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE (task.tk_id<='".$_POST["id_max"]."')
                            ORDER BY task.tk_id ASC";
                        return $sql;
                    }
                }else{//เรียงจากมากไปน้อย
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0 AND (task.tk_id<='".$_POST["id_max"]."')
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1 AND (task.tk_id<='".$_POST["id_max"]."')
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2 AND (task.tk_id<='".$_POST["id_max"]."')
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE (task.tk_id<='".$_POST["id_max"]."')
                            ORDER BY task.tk_id DESC";
                        return $sql;
                    }
                }
            }if ($_POST["id_min"] != "" && $_POST["id_max"] != "") { // ใส่ id ทั้งคู่
                if (isset($_POST["id"]) && $_POST["id"] == "Lowest_to_Highest") { // เรียงจากน้อยไปมาก
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0 AND ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1 AND ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2 AND ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                                ORDER BY task.tk_id ASC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                            ORDER BY task.tk_id ASC";
                        return $sql;
                    }
                }else{//เรียงจากมากไปน้อย
                    if (isset($_POST["status"])) {
                        if ($_POST["status"] == "0") { // รอดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 0 AND ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "1") { // กำลังดำเนินการ
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 1 AND ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        } else if ($_POST["status"] == "2") { // ดำเนินการเสร็จสิ้น
                            $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                       users.first_name AS engineer_first_name,
                                       users.last_name AS engineer_last_name, 
                                       task.org_name, task.building_name, task.lift_id, task.tools
                                FROM task
                                INNER JOIN users ON task.mainten_id = users.id
                                WHERE task.tk_status = 2 AND ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                                ORDER BY task.tk_id DESC";
                            return $sql;
                        }
                    } else {// ไม่ได้ส่งค่า status มาเลย
                        $sql = "SELECT task.tk_id, task.tk_status, task.tk_data, task.rp_id,
                                   users.first_name AS engineer_first_name,
                                   users.last_name AS engineer_last_name, 
                                   task.org_name, task.building_name, task.lift_id, task.tools
                            FROM task
                            INNER JOIN users ON task.mainten_id = users.id
                            WHERE ((task.tk_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (task.tk_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) 
                            ORDER BY task.tk_id DESC";
                        return $sql;
                    }
                }
            }
        }
    }
?>