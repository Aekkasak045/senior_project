<?php
require("inc_db.php");

if (isset($_GET['mainten_id'])) {
    $mainten_id = $_GET['mainten_id'];

    $sql = "SELECT first_name, last_name, username, phone, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mainten_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mainten = $result->fetch_assoc();
        echo json_encode($mainten);
    } else {
        echo json_encode(['error' => 'Mainten not found']);
    }

    $stmt->close();
}
?>
