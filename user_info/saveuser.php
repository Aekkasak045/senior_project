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
    if (!empty($password)) {
        // If password is provided, hash it and include in the query
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($imageData) {
            // If image is uploaded and password is updated
            $stmt = $conn->prepare("UPDATE users SET username=?, password=?, first_name=?, last_name=?, email=?, phone=?, bd=?, role=?, user_img=? WHERE id=?");
            $stmt->bind_param('ssssssssbi', $username, $hashed_password, $first_name, $last_name, $email, $phone, $bd, $role, $imageData, $id);
            $stmt->send_long_data(8, $imageData);
        } else {
            // If no image is uploaded but password is updated
            $stmt = $conn->prepare("UPDATE users SET username=?, password=?, first_name=?, last_name=?, email=?, phone=?, bd=?, role=? WHERE id=?");
            $stmt->bind_param('ssssssssi', $username, $hashed_password, $first_name, $last_name, $email, $phone, $bd, $role, $id);
        }
    } else {
        // If no password is provided, do not update password
        if ($imageData) {
            // If image is uploaded but password is not updated
            $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=?, phone=?, bd=?, role=?, user_img=? WHERE id=?");
            $stmt->bind_param('ssssssssi', $username, $first_name, $last_name, $email, $phone, $bd, $role, $imageData, $id);
            $stmt->send_long_data(7, $imageData);
        } else {
            // If no image is uploaded and no password is updated
            $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=?, phone=?, bd=?, role=? WHERE id=?");
            $stmt->bind_param('sssssssi', $username, $first_name, $last_name, $email, $phone, $bd, $role, $id);
        }
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
