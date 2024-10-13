<?php
    // filter ของหน้า Tools
    function filter_tools() {
        $tools = "";
        $option = "";
        if (isset($_POST["option"])) {
            if ($_POST["option"] == "P_H") { // เรียงราคาจากมากไปน้อย
                $option = "ORDER BY cost DESC";
            } elseif ($_POST["option"] == "P_L") { // เรียงราคาจากน้อยไปมาก
                $option = "ORDER BY cost ASC";
            } elseif ($_POST["option"] == "ID_H") { // เรียง ID มากไปน้อย
                $option = "ORDER BY tool_id DESC";
            } else { // เรียง ID น้อยไปมาก
                $option = "ORDER BY tool_id ASC";
            }
        }
        if (isset($_POST["id_min"]) && isset($_POST["id_max"])) {
            if ($_POST["id_min"] == "" && $_POST["id_max"] == "") { // ไม่ใส่ ID
                if (isset($_POST["p_min"]) && isset($_POST["p_max"])) {
                    if ($_POST["p_min"] == "" && $_POST["p_max"] == "") { // ไม่ใส่ราคา
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "WHERE tool_name LIKE '%" . $_POST["tools"] . "%'";
                            }
                        }
                        $sql = "SELECT * FROM `tools` " . $tools . " " . $option . ";";
                        return $sql;
                    }else{
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "AND tool_name LIKE '%" . $_POST["tools"] . "%'";
                            }
                        }
                        if ($_POST["p_min"] != "" && $_POST["p_max"] == "") { // ไม่ใส่ราคาน้อย
                            $cost="(cost >= '".$_POST["p_min"]."')";
                        }elseif ($_POST["p_min"] == "" && $_POST["p_max"] != "") { // ไม่ใส่ราคามาก
                            $cost="(cost <= '".$_POST["p_max"]."')";
                        }else{ // ใส่ราคา
                            $cost="((cost BETWEEN '".$_POST["p_min"]."' and '".$_POST["p_max"]."') OR (cost BETWEEN '".$_POST["p_max"]."' and '".$_POST["p_min"]."'))";
                        }
                        $sql = "SELECT * FROM `tools` WHERE ".$cost." " . $tools . " " . $option . ";";
                        return $sql;
                    }
                }
            }elseif ($_POST["id_min"] != "" && $_POST["id_max"] == ""){ // ใส่ ID น้อย
                $id="(tool_id >= '".$_POST["id_min"]."')";
                if (isset($_POST["p_min"]) && isset($_POST["p_max"])) {
                    if ($_POST["p_min"] == "" && $_POST["p_max"] == "") { // ไม่ใส่ราคา
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "tool_name LIKE '%" . $_POST["tools"] . "%' AND";
                            }
                        }
                        $sql = "SELECT * FROM `tools` WHERE " . $tools . " " . $id . " " . $option . ";";
                        return $sql;
                    }else{
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "AND tool_name LIKE '%" . $_POST["tools"] . "%'";
                            }
                        }
                        if ($_POST["p_min"] != "" && $_POST["p_max"] == "") { // ไม่ใส่ราคาน้อย
                            $cost="(cost >= '".$_POST["p_min"]."') AND";
                        }elseif ($_POST["p_min"] == "" && $_POST["p_max"] != "") { // ไม่ใส่ราคามาก
                            $cost="(cost <= '".$_POST["p_max"]."') AND";
                        }else{ // ใส่ราคา
                            $cost="((cost BETWEEN '".$_POST["p_min"]."' and '".$_POST["p_max"]."') OR (cost BETWEEN '".$_POST["p_max"]."' and '".$_POST["p_min"]."')) AND";
                        }
                        $sql = "SELECT * FROM `tools` WHERE ".$cost." " . $id . " " . $tools . " " . $option . ";";
                        return $sql;
                    }
                }
            }elseif ($_POST["id_min"] != "" && $_POST["id_max"] == ""){ // ใส่ ID มาก
                $id="(tool_id <= '".$_POST["id_max"]."')";
                if (isset($_POST["p_min"]) && isset($_POST["p_max"])) {
                    if ($_POST["p_min"] == "" && $_POST["p_max"] == "") { // ไม่ใส่ราคา
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "tool_name LIKE '%" . $_POST["tools"] . "%' AND";
                            }
                        }
                        $sql = "SELECT * FROM `tools` WHERE " . $tools . " " . $id . " " . $option . ";";
                        return $sql;
                    }else{
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "AND tool_name LIKE '%" . $_POST["tools"] . "%'";
                            }
                        }
                        if ($_POST["p_min"] != "" && $_POST["p_max"] == "") { // ไม่ใส่ราคาน้อย
                            $cost="(cost >= '".$_POST["p_min"]."') AND";
                        }elseif ($_POST["p_min"] == "" && $_POST["p_max"] != "") { // ไม่ใส่ราคามาก
                            $cost="(cost <= '".$_POST["p_max"]."') AND";
                        }else{ // ใส่ราคา
                            $cost="((cost BETWEEN '".$_POST["p_min"]."' and '".$_POST["p_max"]."') OR (cost BETWEEN '".$_POST["p_max"]."' and '".$_POST["p_min"]."')) AND";
                        }
                        $sql = "SELECT * FROM `tools` WHERE ".$cost." " . $id . " " . $tools . " " . $option . ";";
                        return $sql;
                    }
                }
            }else { // ใส่ ID
                $id="((tool_id BETWEEN '".$_POST['id_min']."' and '".$_POST['id_max']."') OR (tool_id BETWEEN '".$_POST['id_max']."' and '".$_POST['id_min']."'))";
                if (isset($_POST["p_min"]) && isset($_POST["p_max"])) {
                    if ($_POST["p_min"] == "" && $_POST["p_max"] == "") { // ไม่ใส่ราคา
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "tool_name LIKE '%" . $_POST["tools"] . "%' AND";
                            }
                        }
                        $sql = "SELECT * FROM `tools` WHERE " . $tools . " " . $id . " " . $option . ";";
                        return $sql;
                    }else{
                        if (isset($_POST["tools"])) {
                            if ($_POST["tools"] == "") { // ไม่ใส่อุปกรณ์
                                $tools = "";
                            } else { // ใส่อุปกรณ์
                                $tools = "AND tool_name LIKE '%" . $_POST["tools"] . "%'";
                            }
                        }
                        if ($_POST["p_min"] != "" && $_POST["p_max"] == "") { // ไม่ใส่ราคาน้อย
                            $cost="(cost >= '".$_POST["p_min"]."') AND";
                        }elseif ($_POST["p_min"] == "" && $_POST["p_max"] != "") { // ไม่ใส่ราคามาก
                            $cost="(cost <= '".$_POST["p_max"]."') AND";
                        }else{ // ใส่ราคา
                            $cost="((cost BETWEEN '".$_POST["p_min"]."' and '".$_POST["p_max"]."') OR (cost BETWEEN '".$_POST["p_max"]."' and '".$_POST["p_min"]."')) AND";
                        }
                        $sql = "SELECT * FROM `tools` WHERE ".$cost." " . $id . " " . $tools . " " . $option . ";";
                        return $sql;
                    }
                }
            }
        }
    }