<?php
session_start();
include_once "../../login_signup/php/config.php";

if (isset($_SESSION['unique_id']) && isset($_POST['group_id']) && isset($_POST['groupName'])) {
    $unique_id = $_SESSION['unique_id'];

    // Retrieve user_id from the users table based on unique_id
    $user_sql = mysqli_query($conn, "SELECT user_id FROM users WHERE unique_id = {$unique_id}");

    if (mysqli_num_rows($user_sql) > 0) {
        $user_row = mysqli_fetch_assoc($user_sql);
        $user_id = $user_row['user_id'];

        $group_id = $_POST['group_id'];
        $new_group_name = mysqli_real_escape_string($conn, $_POST['groupName']);

        // Update the group name in the group_chats table
        $update_group_sql = mysqli_query($conn, "UPDATE group_chats SET group_name = '{$new_group_name}' WHERE group_id = {$group_id}");

        if ($update_group_sql) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "invalid sql";
    }
} else {
    echo "invalid";
}

