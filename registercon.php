<?php include 'database.php';
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // ✅ Secure hashing
//$password = $_POST['password'];

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES(?, ?, ? )");
$stmt->bind_param("sss", $username, $email, $password);
$stmt->execute();
echo "<script>alert('Registration Succcesful');window.location.href = 'index.php';</script>";
?>