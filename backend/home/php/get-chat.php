<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "../../login_signup/php/config.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $group_id = isset($_POST['group_id']) ? mysqli_real_escape_string($conn, $_POST['group_id']) : '';

    if (!empty($group_id)) {
        // Handle group chat
        $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE messages.group_id = '{$group_id}'
                ORDER BY msg_id";
    } else {
        // Handle one-on-one chat
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = '{$outgoing_id}' AND incoming_msg_id = '{$incoming_id}') 
                OR (outgoing_msg_id = '{$incoming_id}' AND incoming_msg_id = '{$outgoing_id}') 
                ORDER BY msg_id";
    }

    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $output = "";
        while ($row = mysqli_fetch_assoc($query)) {
            $imageTag = !empty($row['images']) ? '<img class="chat-image" src="http://localhost/UYChat/backend/home/php/chat-img/' . $row['images'] . '" alt="Image">' : '';
            
            // Construct the message HTML
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                // Outgoing messages
                if (!empty($row['msg'])) {
                    $output .= '<div class="chat outgoing">
                                    <div class="chat-details">
                                        <p>' . $row['msg'] . '</p>
                                        ' . $imageTag . '
                                    </div>
                                </div>';
                } else {
                    // If no text, display only the image
                    $output .= '<div class="chat outgoing">
                                    <div class="chat-details">
                                        ' . $imageTag . '
                                    </div>
                                </div>';
                }
            } else {
                // Incoming messages
                if (!empty($row['msg'])) {
                    $output .= '<div class="chat incoming">
                                    <img class="incoming-chat" src="../../backend/login_signup/php/images/' . $row['img'] . '" alt="" />
                                    <div class="chat-details">
                                        <p>' . $row['msg'] . '</p>
                                        ' . $imageTag . '
                                    </div>
                                </div>';
                } else {
                    // If no text, display only the image
                    $output .= '<div class="chat incoming">
                                    <img class="incoming-chat" src="../../backend/login_signup/php/images/' . $row['img'] . '" alt="" />
                                    <div class="chat-details">
                                        ' . $imageTag . '
                                    </div>
                                </div>';
                }
            }
        }

        echo $output;
    }
} else {
    header("location: ../../../frontend/login_signup/login_signup.php");
}
session_write_close();
