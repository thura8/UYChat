<?php
  session_start();
  if (!isset($_SESSION['unique_id'])) {
    header("location: ../login_signup/login_signup.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UYChat - message</title>
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="../img/logo.png" />
    <link rel="stylesheet" href="./styles.css" />
  </head>
  <body>
    <main class="container">
      <div class="box">
        <div class="inner-box">
          <section class="chat-area">
            <header>
              <?php
                include_once "../../backend/login_signup/php/config.php";

                $group_id = null;
                if (isset($_GET['user_id'])) {                 
                  $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
                  if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                  }
                } elseif (isset($_GET['group_id'])) {
                  $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
                  $sql = mysqli_query($conn, "SELECT * FROM group_chats WHERE group_id = {$group_id}");
                  if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                    $row['full_name'] = $row['group_name']; // Retrieve the group name
                    $row['status'] = 'Group Chat'; // Set the status to "Group Chat"
                  } else {
                    // Handle the case where the group chat details are not found
                    $row['full_name'] = 'Unknown Group';
                    $row['status'] = 'Group Chat'; // Set the status to "Group Chat"
                  }
                } else {
                  header("location: home.php");
                }                 
              ?> 

              <a href="home.php" class="back-icon">
                <i class="fas fa-arrow-left"></i>
              </a>

              <?php if (isset($_GET['user_id'])) { ?>
                <img src="../../backend/login_signup/php/images/<?php echo $row['img']; ?>" alt="" />
              <?php } ?>

              <div class="chat-details">
                <span><?php echo $row['full_name']; ?></span>
                <p><?php echo $row['status']; ?></p>
              </div>

              <?php if (isset($group_id)): ?>
                <!-- Button to open the pop-up -->
                <button id="editGroupBtn">Edit Group</button>
              <?php endif; ?>
            </header>

            <div class="chat-box">
              <!-- Chat messages will appear here -->
            </div>

            <form action="#" class="typing-area" autocomplete="off" enctype="multipart/form-data">
              <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden />

              <?php if (isset($group_id)): ?>
                <input type="text" name="group_id" value="<?php echo $group_id; ?>" hidden />
              <?php else: ?>
                <input type="text" name="incoming_id" value="<?php echo $user_id; ?>" hidden />
              <?php endif; ?>

              <input type="text" name="message" class="input-field" placeholder="Send a message here..." />
              <input type="file" name="photo" id="photo-input" accept="image/*" style="display: none;" />
              <button type="button" id="photo-button"><i class="fa-solid fa-camera"></i></button>
              <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
          </section>
        </div>
      </div>
    </main>

    <!-- Pop-up Box -->
    <form id="editGroupPopup" class="popup" method="POST">

      <div class="GroupPopUp-content">
        <span class="closeGroup">&times;</span>
        <h2>Edit Group Chat</h2>

        <label for="groupName">Group Chat Name:</label>
        <input type="text" id="groupName" name="groupName" value="<?php echo $row['full_name']; ?>">

        <!-- Hidden field for group_id -->
        <input type="hidden" id="groupId" name="group_id" value="<?php echo $group_id; ?>">

        <h3>Group Participants</h3>
        <div class="participants-list-container">
          <ul id="participantsList">
            <?php
              if (isset($group_id)) {
                $participants_sql = mysqli_query($conn, "SELECT u.full_name FROM group_chat_participants gcp JOIN users u ON gcp.user_id = u.user_id WHERE gcp.group_id = $group_id");
                while ($participant = mysqli_fetch_assoc($participants_sql)) {
                  echo "<li>" . $participant['full_name'] . "</li>";
                }
              }
            ?>
          </ul>
        </div>

        <div class="button-container">
          <button type="submit" id="saveChanges">Save Changes</button>
          <button type="submit" id="leaveGroup">Leave Group</button>
        </div>

      </div>

    </form>




    <script src="chat.js"></script>
  </body>
</html>
