<?php

while ($row = mysqli_fetch_assoc($sql)) {

    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']} OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);

    // Check if the query returned any result
    if ($row2) {
        // Determine message type (text or image)
        if (!empty($row2['images'])) {
            // If an image is sent
            $result = "You sent an image";
            $msg = $result;
        } else {
            // If a text message is sent
            $result = $row2['msg'];

            // Adding "You: " text before the message if the logged-in user sent the message
            $you = ($outgoing_id == $row2['outgoing_msg_id']) ? "You: " : "";

            // Trimming message if words are more than 28 characters
            $msg = (strlen($you . $result) > 28) ? substr($you . $result, 0, 28) . '...' : $you . $result;
        }

    } else {
        // Default message when no messages are found
        $result = "No message available";
        $msg = $result;
        $you = ""; // No need for "You: " prefix if no message
    }

    // Check user is online or offline
    ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

    $output .= '
    <div class="users-list-container">
        <a href="chat.php?user_id=' . $row['unique_id'] . '" class="user-link" data-name="' . $row['full_name'] . '" data-img="/UYchat/backend/login_signup/php/images/' . $row['img'] . '" data-status="' . $row['status'] . '">
        <div class="users-content">
            <img src="/UYchat/backend/login_signup/php/images/' . $row['img'] . '" alt="" />
            <div class="details">
                <span>' . $row['full_name'] . '</span>
                <p>' . $msg . '</p>
            </div>
        </div>
        <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
        </a>
    </div>
    ';
}
