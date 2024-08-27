<?php
    session_start();
    if(isset($_SESSION['unique_id'])){ // if user is logged in then come to this page otherwise go to login page
        include_once "../../login_signup/php/config.php";

        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){// if logout id is set
            $status = "Offline now";
            //once user logout then we will update this status to offline and in the login form
            // we wll update the status again to active now if user logged in successfully

            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id}");


            if($sql){
                session_unset();
                session_destroy();
                header("location: ../../../frontend/login_signup/login_signup.php");
            }

        }else{
            header("location: ../../../frontend/home/home.php");
        }

    }else{
        header("location: ../../../frontend/login_signup/login_signup.php");
    }
    session_write_close();