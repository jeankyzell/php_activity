<?php
require_once 'includes/auth.php';

$errors = [];
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === "") {
        $errors[] = "Please enter your username";
    } elseif (!preg_match("/^[a-zA-Z]{3,20}$/", $username)) {
        $errors[] = "Username must be 3-20 letters only and cannot contain numbers";
    } elseif ($username === strtoupper($username)) {
        $errors[] = "Username cannot be all uppercase";
    }

    if ($password === "") {
        $errors[] = "Please enter your password";
    } elseif (strlen($password) < 5) {
        $errors[] = "Password must be at least 5 characters";
    }

    if (empty($errors)) {
        $user = findUser($username);

        if ($user === null) {
            $errors[] = "Account does not exist. Please register first.";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Invalid credentials. Wrong username or password.";
        } else {
            $_SESSION['loggedUser'] = $user['username'];
            header("Location: login-successful.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'includes/header.php'; ?>
  <title>Login Page - Activity</title>
  <link rel="stylesheet" href="design.css">
</head>
<body>
  <main>
    <div class="glass-card">
      <h2 class="login-title">Login</h2>

      <?php if (!empty($errors)): ?>
      <div class="error-box">
      <?php foreach ($errors as $err): ?>
      <div class="error-item"><?php echo htmlspecialchars($err); ?></div>
     <?php endforeach; ?>
     </div>
      <?php endif; ?>

      <form id="loginForm" method="POST" action="">
        <div class="input-group user">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
        </div>
        <div class="input-group password">
          <label for="password">Password</label>
          <input type="password" id="password" name="password">
        </div>
        <div class="options">
          <div>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
          </div>
          <a href="#">Forgot password?</a>
        </div>
        <button type="submit" class="btn-custom">Login</button>
        <p>Don’t have an account? <a href="register.php">Register</a></p>
      </form>
    </div>
  </main>
</body>
</html>