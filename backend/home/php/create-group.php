<?php
session_start();

if (isset($_SESSION['unique_id'])) {
    include_once "../../login_signup/php/config.php";

    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);
    $participants = $_POST['participants']; // This is an array of unique_ids

    if (!empty($group_name) && !empty($participants)) {
        // Insert the new group into the group_chats table
        $sql = "INSERT INTO group_chats (group_name) VALUES ('{$group_name}')";
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            // Get the group ID of the newly created group
            $group_id = mysqli_insert_id($conn);

            // Add each participant (including the creator) to the group_chat_participants table
            foreach ($participants as $unique_id) {
                $unique_id = (int)$unique_id;

                // Retrieve the user_id from the users table based on the unique_id
                $query = "SELECT user_id FROM users WHERE unique_id = {$unique_id}";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $user_id = mysqli_fetch_assoc($result)['user_id'];

                    // Debugging output
                    echo "Adding user_id: {$user_id} to group_id: {$group_id}<br>";

                    // Attempt to insert the user into the group
                    $insert_query = "INSERT INTO group_chat_participants (group_id, user_id) VALUES ({$group_id}, {$user_id})";
                    $insert_result = mysqli_query($conn, $insert_query);

                    if (!$insert_result) {
                        echo "Error inserting user_id: {$user_id} - " . mysqli_error($conn) . " (Query: {$insert_query})";
                        exit;
                    }
                } else {
                    echo "Error: Unique ID $unique_id does not exist in the users table.";
                    exit;
                }
            }

            // Add the creator as a participant if not already in the participants list
            $creator_unique_id = (int)$_SESSION['unique_id'];
            $query = "SELECT user_id FROM users WHERE unique_id = $creator_unique_id";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $creator_id = mysqli_fetch_assoc($result)['user_id'];

                if (!in_array($creator_unique_id, $participants)) {
                    $insert_query = "INSERT INTO group_chat_participants (group_id, user_id) VALUES ({$group_id}, {$creator_id})";
                    $insert_result = mysqli_query($conn, $insert_query);

                    if (!$insert_result) {
                        echo "Error inserting creator_id: {$creator_id} - " . mysqli_error($conn) . " (Query: {$insert_query})";
                        exit;
                    }
                }
            } else {
                echo "Error: Creator's unique ID does not exist in the users table.";
                exit;
            }

            echo "Group created successfully!";
        } else {
            echo "Failed to create group!";
        }
    } else {
        echo "Group name or participants are missing!";
    }
} else {
    header("location: ../../../frontend/login_signup/login_signup.php");
}
