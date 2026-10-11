<?php
session_start();
if (!isset($_SESSION['loggedUser'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Successful</title>
  <link rel="stylesheet" href="design.css">
  <style>
    .glass-card {
      text-align: center;
      padding: 50px;
      max-width: 500px;
      margin: auto;
      margin-bottom: 60px;
    }
    .center-btn {
      display: flex;
      justify-content: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <main>
    <div class="glass-card">
      <h2>Login Successful!</h2>
      <p>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['loggedUser']); ?></strong>.</p>
      <div class="center-btn">
        <a href="index.php" class="btn-custom">Go to Landing Page</a>
      </div>
      <div class="center-btn">
        <a href="logout.php" class="btn-custom">Logout</a>
      </div>
    </div>
  </main>
</body>
</html>