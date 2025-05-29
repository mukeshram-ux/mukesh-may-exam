
<?php
session_start();
require_once 'db.php'; // Yeh file me DB connection hai

// Check agar form submit hua hai
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input sanitize karo
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        die("Please fill all the fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        die("Invalid phone number.");
    }

    if (strlen($password) < 6) {
        die("Password must be at least 6 characters.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die("Email is already registered.");
    }
    $stmt->close();

    // Password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful. You can now <a href='login.html'>login</a>.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

