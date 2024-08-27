<?php
include_once "../../login_signup/php/config.php";

$outgoing_id = $_SESSION['unique_id'];
$sqlGroups = mysqli_query($conn, "SELECT group_chats.group_id, group_chats.group_name 
                                  FROM group_chats 
                                  INNER JOIN group_chat_participants 
                                  ON group_chats.group_id = group_chat_participants.group_id 
                                  WHERE group_chat_participants.user_id = (SELECT user_id FROM users WHERE unique_id = {$outgoing_id})");

if(mysqli_num_rows($sqlGroups) > 0){
    while($group = mysqli_fetch_assoc($sqlGroups)){
        // Create the group chat structure similar to one-on-one chat
        $output .= '
        <div class="users-list-container">
            <a href="chat.php?group_id=' . $group['group_id'] . '" class="user-link">
            <div class="users-content">
                <i class="fa-solid fa-user-group"></i>
                <div class="details">
                    <span>' . $group['group_name'] . '</span>
                </div>
            </div>
            </a>
            
        </div>
        ';
    }
} else {
    $output .= "No group chats found";
}
