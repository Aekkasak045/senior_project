<?php
require("inc_db.php");

if (isset($_POST['updatedata'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bd = $_POST['bd'];
    $role = $_POST['role'];

    // Handle Image Upload
    $imageData = null;
    if (isset($_FILES['user_img']) && $_FILES['user_img']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['user_img']['tmp_name']);
    }

    // Update Query
    if ($imageData) {
        // If an image is uploaded, include it in the update
        $stmt = $conn->prepare("UPDATE users SET username=?, password=?, first_name=?, last_name=?, email=?, phone=?, bd=?, role=?, user_img=? WHERE id=?");
        $stmt->bind_param('sssssssbsi', $username, $password, $first_name, $last_name, $email, $phone, $bd, $role, $imageData, $id);
        $stmt->send_long_data(8, $imageData); // Send the image data to the statement
    } else {
        // If no image is uploaded, do not update the user_img field
        $stmt = $conn->prepare("UPDATE users SET username=?, password=?, first_name=?, last_name=?, email=?, phone=?, bd=?, role=? WHERE id=?");
        $stmt->bind_param('ssssssssi', $username, $password, $first_name, $last_name, $email, $phone, $bd, $role, $id);
    }

    if ($stmt->execute()) {
        echo '<script>alert("User Updated Successfully!");</script>';
    } else {
        echo '<script>alert("Failed to Update User!");</script>';
    }

    $stmt->close();
    $conn->close();
    
    header("Location: user_information.php"); // Redirect to the user information page after update
}
?>
