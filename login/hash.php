<?php
require_once '..\function.php';

$conn = db_connect();

$id = uniqid();
$firstname = "charbel";
$lastname = "hakim";
$phonenum = "81186325";
$email = 'user@example.com';
$password = 'password123';
$role = "a";


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$query = "INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `PhoneNumber`, `Email`, `Password` , `role`) VALUES (?, ?, ?, ?, ? , ?, ?);";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssss",$id , $firstname , $lastname , $phonenum , $email, $hashedPassword ,$role);
$stmt->execute();

$stmt->close();
$conn->close();

echo "User added with hashed password.";
?>