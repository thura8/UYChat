<?php 
session_start();
include_once "../../login_signup/php/config.php";

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$output = "";

// Get the user ID based on the unique_id
$userQuery = mysqli_query($conn, "SELECT user_id FROM users WHERE unique_id = {$outgoing_id}");
$userRow = mysqli_fetch_assoc($userQuery);
$user_id = $userRow['user_id'];

// Search users by full name and major
$sqlUsers = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (full_name LIKE '%{$searchTerm}%' OR major LIKE '%{$searchTerm}%')");

// Search group chats where the user is a participant and the group name matches the search term
$sqlGroups = mysqli_query($conn, "SELECT gc.* FROM group_chats gc
                                  INNER JOIN group_chat_participants gcp ON gc.group_id = gcp.group_id
                                  WHERE gcp.user_id = {$user_id} AND gc.group_name LIKE '%{$searchTerm}%'");

if(mysqli_num_rows($sqlUsers) > 0 || mysqli_num_rows($sqlGroups) > 0) {

    // Display users
    $displayedMajor = false;
    while($row = mysqli_fetch_assoc($sqlUsers)) {
        if (stripos($row['major'], $searchTerm) !== false && !$displayedMajor) {
            $output .= "<h3>" . $row['major'] . "</h3>";
            $displayedMajor = true;
        } elseif (!$displayedMajor) {
            $output .= "<h3>Users</h3>";
            $displayedMajor = true;
        }

        // Assuming you have a function to determine the user's status (online/offline)
        $status = $row['status'] === 'Online' ? 'online' : 'offline'; // Example logic for status

        $output .= '
        <div class="users-list-container">
            <a href="chat.php?user_id=' . $row['unique_id'] . '" class="user-link" data-name="' . $row['full_name'] . '" data-img="/UYchat/backend/login_signup/php/images/' . $row['img'] . '" data-status="' . $row['status'] . '">
            <div class="users-content">
                <img src="/UYchat/backend/login_signup/php/images/' . $row['img'] . '" alt="" />
                <div class="details">
                    <span>' . $row['full_name'] . '</span>
                    <p>No messages</p> <!-- Example placeholder -->
                </div>
            </div>
            <div class="status-dot ' . $status . '"><i class="fas fa-circle"></i></div>
            </a>
        </div>
        ';
    }

    // Display group chats
    if(mysqli_num_rows($sqlGroups) > 0) {
        $output .= "<h3>Group Chats</h3>";
        while($row = mysqli_fetch_assoc($sqlGroups)) {
            $output .= '
        <div class="users-list-container">
            <a href="chat.php?group_id=' . $row['group_id'] . '" class="user-link">
            <div class="users-content">
                <i class="fa-solid fa-user-group"></i>
                <div class="details">
                    <span>' . $row['group_name'] . '</span>
                </div>
            </div>
            </a>
        </div>
        ';
        }
    }

} else {
    $output .= "No user or group found related to your search term";
}

echo $output;
session_write_close();

