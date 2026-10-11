<?php
require_once 'includes/auth.php';

$errors = [];
$username = $email = $phone = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm'] ?? '');

    if ($username === "") {
        $errors[] = "Please enter a username";
    } elseif (!preg_match("/^[a-zA-Z]{3,20}$/", $username)) {
        $errors[] = "Username must be 3-20 letters only and cannot contain numbers";
    } elseif ($username === strtoupper($username)) {
        $errors[] = "Username cannot be all uppercase";
    } elseif (findUser($username) !== null) {
        $errors[] = "Username already taken";
    }

    if ($email === "") {
        $errors[] = "Please enter your email";
    } elseif (!preg_match("/^[\w\.\-]+@[\w\-]+\.[a-zA-Z]{2,}$/", $email)) {
        $errors[] = "Please enter a valid email address";
    }

    if ($phone === "") {
        $errors[] = "Please enter your phone number";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $errors[] = "Phone number must be 10-15 digits";
    }

    if ($password === "") {
        $errors[] = "Please provide a password";
    } elseif (strlen($password) < 5) {
        $errors[] = "Password must be at least 5 characters";
    }

    if ($confirm === "") {
        $errors[] = "Please confirm your password";
    } elseif ($password !== $confirm) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        addUser($username, $email, $phone, $password);
        header("Location: registered-successful.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'includes/header.php'; ?>
  <title>Register Page - Activity</title>
  <link rel="stylesheet" href="design.css">
</head>
<body>
  <main>
    <div class="glass-card">
      <h2 class="register-title">Register</h2>

      <?php if (!empty($errors)): ?>
      <div class="error-box">
      <?php foreach ($errors as $err): ?>
      <div class="error-item"><?php echo htmlspecialchars($err); ?></div>
      <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <form id="registerForm" method="POST" action="">
        <div class="input-group user">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
        </div>
        <div class="input-group email">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="input-group phone">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        </div>
        <div class="input-group password">
          <label for="password">Password</label>
          <input type="password" id="password" name="password">
        </div>
        <div class="input-group password">
          <label for="confirm">Confirm Password</label>
          <input type="password" id="confirm" name="confirm">
        </div>
        <button type="submit" class="btn-custom">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a></p>
      </form>
    </div>
  </main>
</body>
</html>