<?php
session_start();
include_once "../../login_signup/php/config.php";

if (isset($_SESSION['unique_id']) && isset($_POST['group_id'])) {
    $unique_id = $_SESSION['unique_id'];
    
    // Retrieve user_id from the users table based on unique_id
    $user_sql = mysqli_query($conn, "SELECT user_id FROM users WHERE unique_id = {$unique_id}");
    
    if (mysqli_num_rows($user_sql) > 0) {
        $user_row = mysqli_fetch_assoc($user_sql);
        $user_id = $user_row['user_id'];
        
        $group_id = $_POST['group_id'];

        // Remove the user from the group_chat_participants table
        $leave_group_sql = mysqli_query($conn, "DELETE FROM group_chat_participants WHERE group_id = {$group_id} AND user_id = {$user_id}");

        if ($leave_group_sql) {
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

