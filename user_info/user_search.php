<?php
include ("inc_db.php");
include ("user_function.php");

$keyword = $_POST['search'];

$sql = "SELECT * FROM users WHERE id LIKE '%$keyword%' OR username LIKE '%$keyword%' OR password LIKE '%$keyword%'OR first_name LIKE '%$keyword%'OR last_name LIKE '%$keyword%' OR email LIKE '%$keyword%'OR phone LIKE '%$keyword%' OR bd LIKE '%$keyword%' OR role LIKE '%$keyword%' ";
$rs = mysqli_query($conn, $sql);
$data = '';

while ($row = mysqli_fetch_assoc($rs)) {
    $data .= "<tr class=\"table-lift editbtn\" data-id=\"" . $row["id"] . "\" onclick=\"openEditModal(this)\">"
                . role($row) .
                "<td>" . $row["id"] . "</td>
                <td>" . $row["username"] . "</td>
                <td>" . $row["password"] . "</td>
                <td>" . $row["first_name"] . "</td>
                <td>" . $row["last_name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["phone"] . "</td>
                <td>" . $row["bd"] . "</td>"
                .show_role($row).
                "</tr>";
    }
    echo $data;
?>