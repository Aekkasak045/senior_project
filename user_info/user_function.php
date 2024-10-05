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

    // filter ของหน้า User Information
    function filter_user() {
        if (isset($_POST["bd_min"])&&isset($_POST["bd_max"])) {
            if ($_POST["bd_min"] == ""&&$_POST["bd_max"]=="") {//ไม่ใส่ Birthday
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){//ไม่ใส่ id
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }
                }
            }
            if ($_POST["bd_min"] != ""&&$_POST["bd_max"]=="") {//ไม่ใส่ Birthday มากแต่ใส่น้อย
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }
                }
            }
            if ($_POST["bd_min"] == ""&&$_POST["bd_max"]!="") {//ไม่ใส่ Birthday น้อยแต่ใส่มาก
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }
                }
            }
            else{//ใส่ Birthday ทั้งคู่
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."')) ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (role='".$_POST['role']."') AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){//ไม่ใส่ id
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){//ใส่ id น้อยแต่ไม่ใส่มาก
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){//ใส่ id มากแต่ไม่ใส่น้อย
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{//ใส่ id ทั้งคู่
                                $sql = "SELECT * FROM users WHERE ((bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') OR (bd BETWEEN '".$_POST['bd_max']."' and '".$_POST['bd_min']."')) AND ((id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                                return $sql;
                            }
                        }
                    }
                }
            }
        }
    }
?>