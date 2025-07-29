<?php
require 'db.php';
session_start(); 

$success = "";
$error = "";


if (!isset($_SESSION['username'])) {
    die("Unauthorized access. Please <a href='login.php'>login</a>.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $username = $_SESSION['username']; 
    if (empty($title) || strlen($title) < 3) {
        $error = "❗ Title must be at least 3 characters.";
    } elseif (empty($content) || strlen($content) < 10) {
        $error = "❗ Content must be at least 10 characters.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO posts (title, content, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $username);

        if ($stmt->execute()) {
            $success = "✅ Post added successfully!";
        } else {
            $error = "❌ Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
