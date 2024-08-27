<?php

  session_start();
  if(!isset($_SESSION['unique_id'])){
    header("location: ../login_signup/login_signup.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>UYChat - home</title>
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="../img/logo.png" />
    <link rel="stylesheet" href="./styles.css" />
    
  </head>
  <body>
    <main class="container">
      <div class="box">
        <div class="inner-box">

        <?php

include_once "../../backend/login_signup/php/config.php";
$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");

if(mysqli_num_rows($sql) > 0){
  $row = mysqli_fetch_assoc($sql);
}

?> 

          <div class="sidebar">
            <ul>
              <li class="logo">
                <a href="#">
                  <div class="icon">
                    <img src="../img/logo.png" alt="logo" />
                  </div>

                  <div class="text">UYChat</div>
                </a>
              </li>

              <div class="MenuList">
                <li style="--bg: #8371fd" class="active">
                  <a href="#" class="menu-link" data-target="profile">
                    <div class="icon">
                      <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="text">Profile</div>
                  </a>
                </li>

                <li style="--bg: #8371fd">
                  <a href="#" class="menu-link" data-target="friends">
                    <div class="icon">
                      <i class="fa-solid fa-address-book"></i>
                    </div>

                    <div class="text">Friends</div>
                  </a>
                </li>
              </div>

              <div class="bottom">
                <li>
                  <a href="#">
                    <div class="icon">
                      <div class="imgBx">
                        <img src="../../backend/login_signup/php/images/<?php echo $row['img'] ?>" alt="profile" />
                      </div>
                    </div>

                    <div class="text"><?php echo $row['full_name'] ?></div>
                  </a>
                </li>
                <li style="--bg: #8371fd">
                  <a href="../../backend/home/php/logout.php?logout_id=<?php echo $row['unique_id'] ?>">
                    <div class="icon">
                      <i class="fa-solid fa-right-from-bracket"></i>
                    </div>

                    <div class="text">Logout</div>
                  </a>
                </li>
              </div>
            </ul>
          </div>

          <div class="content">
            <div id="profile">
              <div class="profile-container">
                <div class="profile-card">
                  <div class="image">
                    <img
                      src="../../backend/login_signup/php/images/<?php echo $row['img'] ?>"
                      alt=""
                      class="profile-img"
                    />
                  </div>

                  <div class="profile-data">
                    <span class="profile-name"><?php echo $row['full_name'] ?></span>
                    <span class="profile-status"><?php echo $row['status'] ?></span>
                  </div>

                  <div class="profile-details">
                    <div class="profile-fields">
                      <i class="fa-solid fa-circle-user"></i>
                      <h4><span id="age"><?php echo $row['major'] ?></span></h4>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div id="friends" class="hidden">

              <div class="friend-header">

                <div class="search">
                  <span class="search-text">Find your friends</span>
                  <input placeholder="Search..." type="text" />
                  <button type="submit"><i class="fa fa-search"></i></button>
                </div>

                <button id="make-group-chat-btn">Create Group<i class="fa-solid fa-circle-plus"></i></button>

              </div>

              <div class="divider"></div>

              <div class="users-list">
                
              </div>

              <div id="group-chat-popup" class="group-chat-popup">

                <div class="popup-content">

                  <span class="close-btn">&times;</span>
                  <h2>Create Group Chat</h2>
                  <input type="text" id="group-name" placeholder="Group Name" required />

                  <div class="users-list-group" id="users-list-group">
                      <!-- Users list will be dynamically populated here -->
                  </div>

                  <button id="create-group-btn">Done</button>

                </div>

              </div>

              
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- JavaScript file -->

    <script src="./script.js"></script>
    <script src="./group-chat.js"></script>
  </body>
</html>
