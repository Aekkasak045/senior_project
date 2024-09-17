<?php
require ("inc_db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = $_POST['rp_id'];

    // ลบข้อมูล report จากตาราง
    $del_rp = "DELETE FROM report WHERE rp_id = ?";
    $stmt_rp = $conn->prepare($del_rp);
    $stmt_rp->bind_param("i", $report_id);

    if ($stmt_rp->execute()) {
        echo "<script>
        alert('ลบรายงานเรียบร้อย');
        window.location.href = 'report_list.php';
    </script>";
    } else {
        echo "เกิดข้อผิดพลาดในการลบรายงาน: " . $stmt_rp->error;
    }

    $stmt_rp->close();
}

$conn->close();
?>
