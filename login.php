<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'dhanasekar');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_name'] = $user['name'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid password!";
    }
} else {
    echo "No user found with this email!";
}

$stmt->close();
$conn->close();
?>
