<?php

session_start();
include_once "../../login_signup/php/config.php";

// Check if the unique_id session variable is being accessed correctly
if (isset($_SESSION['unique_id'])) {
    $outgoing_id = $_SESSION['unique_id'];
    $sql = "SELECT * FROM users WHERE unique_id != ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $outgoing_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);

    $output = "";
    while ($row = mysqli_fetch_assoc($query)) {
        $output .= '    <div class="user-item">
                            <label>' . $row['full_name'] . '</label>
                            <input type="checkbox" value="' . $row['unique_id'] . '" />
                        </div>';
    }
    echo $output;   
} 

session_write_close();