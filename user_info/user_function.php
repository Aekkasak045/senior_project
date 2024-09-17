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

    function button_role() {
        // if ($row["role"] == "mainten")
        // <button type="submit" name="roledata" class="btn roleuser">ROLE</button>"
    }

    function filter() {
        if (isset($_POST["bd_min"])&&isset($_POST["bd_max"])) {
            if ($_POST["bd_min"] == ""&&$_POST["bd_max"]=="") {
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }
                }
            }
            if ($_POST["bd_min"] != ""&&$_POST["bd_max"]=="") {
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd>='".$_POST['bd_min']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }
                }
            }
            if ($_POST["bd_min"] == ""&&$_POST["bd_max"]!="") {
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd<='".$_POST['bd_max']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }
                }
            }
            else{
                if(isset($_POST["id"])&&($_POST["id"]=="Highest_to_Lowest")){//เรียงจากมากไปน้อย
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (id>='".$_POST["id_min"]."') ORDER BY id DESC";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (id<='".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."') ORDER BY id DESC";
                                return $sql;
                            }
                        }
                    }
                }else{//เรียงจกน้อยไปมาก
                    if(isset($_POST["role"])){//มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (role='".$_POST['role']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }else{//ไม่มี role
                        if(isset($_POST["id_min"])&&isset($_POST["id_max"])){
                            if($_POST["id_min"]==""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."')";
                                return $sql;
                            }if($_POST["id_min"]!=""&&$_POST["id_max"]==""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (id>='".$_POST["id_min"]."')";
                                return $sql;
                            }if($_POST["id_min"]==""&&$_POST["id_max"]!=""){
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (id<='".$_POST["id_max"]."')";
                                return $sql;
                            }else{
                                $sql = "SELECT * FROM users WHERE (bd BETWEEN '".$_POST['bd_min']."' and '".$_POST['bd_max']."') AND (id BETWEEN '".$_POST["id_min"]."' and '".$_POST["id_max"]."')";
                                return $sql;
                            }
                        }
                    }
                }
            }
        }
    }
?>