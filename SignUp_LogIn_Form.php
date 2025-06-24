<?php
    require('connection.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Form</title>
    <link rel="stylesheet" href="SignUp_LogIn_Form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
  <body>

      <div class="container">
          <div class="form-box login">
              <form action="login_register.php" method="POST">
                  <h1>Login</h1>
                  <div class="input-box">
                      <input type="text" placeholder="E-Mail or Username"  name="email_username" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="password" placeholder="Password" name="password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <a href="forget_password.php" style="text-decoration: underline; margin-right: 200px;">forget password</a><br><br>
                  <button type="submit" class="btn" name="login">LOGIN</button>
                  <a href="index.php"><div class="home">Go to home page</div></a>
              </form>
          </div>

          <div class="form-box register">
              <form action="login_register.php" method="POST">
                  <h1>Registration</h1>
                  <div class="input-box">
                      <input type="text" placeholder="Full Name" name="fullname" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="text" placeholder="Username" name="username" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="email" placeholder="Email" name="email" required>
                      <i class='bx bxs-envelope' ></i>
                  </div>
                  <div class="input-box">
                      <input type="password" placeholder="Password" name="password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <button type="submit" class="btn" name="register">REGISTER</button>
                  <a href="index.php"><div class="home">Go to home page</div></a>
              </form>
          </div>

          <div class="toggle-box">
              <div class="toggle-panel toggle-left">
                  <h1>Hello, Welcome!</h1>
                  <p>Don't have an account?</p>
                  <button class="btn register-btn">Register</button>
              </div>

              <div class="toggle-panel toggle-right">
                  <h1>Welcome Back!</h1>
                  <p>Already have an account?</p>
                  <button class="btn login-btn">Login</button>
              </div>
          </div>
      </div>

      <script src="SignUp_LogIn_Form.js"></script>
  </body>
</html>