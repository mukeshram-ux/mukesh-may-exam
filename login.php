<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
      $_SESSION['user'] = $row['username'];
      header("Location: dashboard.php");
      exit;
    } else {
      echo "Invalid password";
    }
  } else {
    echo "User not found";
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
  <h2>Login</h2>
  <form method="POST">
    Username: <input name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
  </form>
</body>
</html>
