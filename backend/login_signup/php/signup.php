<?php

session_start();
include_once "config.php";

// Retrieve and sanitize user inputs
$full_name = filter_var($_POST['full_name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; // Password will be hashed later
$major = filter_var($_POST['selected_major'], FILTER_SANITIZE_STRING);

if (!empty($full_name) && !empty($email) && !empty($password) && !empty($major)) {

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "$email - This email already exists";
        } else {

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                $img_explode = explode('.', $img_name);
                $img_ext = strtolower(end($img_explode)); // Convert extension to lowercase

                $valid_extensions = ['png', 'jpg', 'jpeg'];

                if (in_array($img_ext, $valid_extensions)) {
                    $time = time();
                    $new_img_name = $time . basename($img_name);
                    $target_file = "images/" . $new_img_name;

                    // Validate file size (e.g., max 5MB)
                    if ($_FILES['image']['size'] <= 5000000) {
                        // Move the uploaded file
                        if (move_uploaded_file($tmp_name, $target_file)) {
                            $status = "Active now";
                            $random_id = rand(time(), 10000000); // Consider a better ID generation method

                            // Hash the password
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                            // Insert user data into database
                            $stmt = $conn->prepare("INSERT INTO users (unique_id, full_name, email, password, img, status, major) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("issssss", $random_id, $full_name, $email, $hashed_password, $new_img_name, $status, $major);

                            if ($stmt->execute()) {
                                // Retrieve user data to start session
                                $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                                $stmt->bind_param("s", $email);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $_SESSION['unique_id'] = $row['unique_id']; // Set session ID
                                    echo "success";
                                }

                            } else {
                                echo "Something went wrong!";
                            }

                        } else {
                            echo "Failed to upload image.";
                        }

                    } else {
                        echo "File size is too large. Maximum allowed size is 5MB.";
                    }

                } else {
                    echo "Invalid image file type. Allowed types: jpeg, jpg, png.";
                }

            } else {
                echo "Please select a valid image file!";
            }

        }

    } else {
        echo "$email - This is not a valid email address";
    }

} else {
    echo "Please fill all the fields";
}

session_write_close();

