<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../../login_signup/php/config.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = isset($_POST['incoming_id']) ? mysqli_real_escape_string($conn, $_POST['incoming_id']) : NULL;
    $group_id = isset($_POST['group_id']) ? mysqli_real_escape_string($conn, $_POST['group_id']) : NULL;

    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : NULL;
    $imageName = NULL;

    // Check if an image is uploaded
    if(isset($_FILES['photo']) && $_FILES['photo']['name'] != ''){
        $imageName = time() . "_" . $_FILES['photo']['name'];
        $tmp_name = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmp_name, "chat-img/" . $imageName);
    }

    // Only proceed if there's a message or an image
    if (!empty($message) || !empty($imageName)) {
        if ($group_id !== NULL) {
            // Insert group chat message
            $sql = "INSERT INTO messages (outgoing_msg_id, msg, images, group_id) 
                    VALUES ('{$outgoing_id}', '{$message}', '{$imageName}', '{$group_id}')";
        } else {
            // Insert one-on-one chat message
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, images) 
                    VALUES ('{$incoming_id}', '{$outgoing_id}', '{$message}', '{$imageName}')";
        }
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
} else {
    header("location: ../../../frontend/login_signup/login_signup.php");
}
session_write_close();
