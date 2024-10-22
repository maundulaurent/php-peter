<?php
session_start(); // Start session to manage login state
include 'includes/db.php'; // Database connection

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginInput = mysqli_real_escape_string($conn, $_POST['loginInput']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user exists by email or user_id
    $query = "SELECT * FROM users WHERE (username = '$loginInput' OR user_id = '$loginInput')";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to index.php
            header('Location: index');
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "User not found. Please check your ID/email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page | POS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <style>
    body, html {
      height: 100%;
    }
    .login-container {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body class="hold-transition">

<div class="login-container">
  <div class="card card-primary">
    <div class="card-header text-center">
      <h3 class="card-title">Login to start your session</h3>
    </div>
    <div class="card-body">
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="loginInput">Username/ID</label>
          <input type="text" name="loginInput" class="form-control" id="loginInput" placeholder="Enter username or ID" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
