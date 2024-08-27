<?php

  session_start();
  if(isset($_SESSION['unique_id'])){ //if user is logged in
    header("location: ../home/home.php");
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UYChat - login & sign up</title>
    <link href="../home/assets/fontawesome/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="../img/logo.png" />
    <link rel="stylesheet" href="./styles.css" />
  </head>
  <body>
    <main class="container">
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form action="#" autocomplete="off" class="sign-in-form">
              <div class="logo">
                <img src="../img/logo.png" alt="easyclass" />
                <h4>UYChat</h4>
              </div>

              <div class="heading">
                <h2>Welcome Back</h2>
                <h6>Not registred yet?</h6>
                <a href="#" class="toggle">Sign up</a>
              </div>
              <div class="error-txt">This is an error message!</div>
              <div class="actual-form">
                <div class="input-wrap">
                <input
                    type="email"
                    class="input-field"
                    autocomplete="off"
                    name="email"
                    required
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    name="password"
                    required
                  />
                  <label>Password</label>
                  <i class="fas fa-eye"></i>
                </div>

                <input type="submit" value="Sign In" class="sign-in-btn" />

                <p class="text">
                  Forgotten your password or you login datails?
                  <a href="#">Get help</a> signing in
                </p>
              </div>
            </form>

            <form action="#" method="post" enctype="multipart/form-data" autocomplete="off" class="sign-up-form">
              <div class="logo">
                <img src="../img/logo.png" alt="easyclass" />
                <h4>UYChat</h4>
              </div>

              <div class="heading">
                <h2>Get Started</h2>
                <h6>Already have an account?</h6>
                <a href="#" class="toggle">Sign in</a>
              </div>

              <div class="error-txt"></div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    name="full_name"
                    required
                  />
                  <label>Name</label>
                </div>

                <div class="wrapper">
                  <div class="select-btn">
                    <span>Select Major</span>
                    <i class="fa-solid fa-circle-chevron-down"></i>
                  </div>

                  <div class="content-select">
                    <ul class="options"></ul>
                  </div>

                  <!-- Add this inside your form tag -->
                  <input type="hidden" name="selected_major" id="selected-major" />

                </div>

                <div class="input-wrap">
                  <input
                    type="email"
                    class="input-field"
                    autocomplete="off"
                    name="email"
                    required
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    name="password"
                    required
                  />
                  <label>Password</label>
                  <i class="fas fa-eye"></i>
                </div>

                <div class="input-wrap">
                  <label class="box-label">Upload your photo</label>
                  <input type="file" name="image" class="upload-box" required />
                </div>

                <input type="submit" value="Sign Up" class="sign-up-btn" />

                <p class="text">
                  By signing up, I agree to the
                  <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a>
                </p>
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="../img/image1.png" class="image img-1 show" alt="" />
              <img src="../img/image2.png" class="image img-2" alt="" />
              <img src="../img/image3.png" class="image img-3" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>Stay connected, stay close</h2>
                  <h2>Chat freely, express fully</h2>
                  <h2>From ‘Hello’ to ‘See you soon’</h2>
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript file -->

    <script src="./js/script.js"></script>
    <script src="./js/signup.js"></script>
    <script src="./js/login.js"></script>
    <script src="sample.js"></script>
  </body>
</html>
