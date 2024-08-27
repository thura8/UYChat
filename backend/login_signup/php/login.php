<?php

session_set_cookie_params([
    'lifetime' => 0,  // Session cookie lifetime
    'path' => '/UYChat/backend/',  // Cookie path
    'secure' => true,  // Ensure cookies are sent over HTTPS
    'httponly' => true,  // Prevent JavaScript access to cookies
    'samesite' => 'Strict'  // Restrict cookie usage to same-site requests
]);
session_start();
include_once "config.php";

// Retrieve and sanitize user inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; // Password will be hashed in the database

if (!empty($email) && !empty($password)) {

    // Prepare SQL query to fetch user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { // If email exists

        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {

            // Update user status to 'Active now'
            $status = "Active now";
            $stmt = $conn->prepare("UPDATE users SET status = ? WHERE unique_id = ?");
            $stmt->bind_param("si", $status, $row['unique_id']);
            if ($stmt->execute()) {
                $_SESSION['unique_id'] = $row['unique_id']; // Set session ID
                echo "success";
            } else {
                echo "Failed to update status!";
            }

        } else {
            echo "Email or Password is incorrect!";
        }

    } else {
        echo "Email or Password is incorrect!";
    }

} else {
    echo "All input fields are required!";
}

session_write_close();

