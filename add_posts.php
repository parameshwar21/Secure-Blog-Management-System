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

<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>
    <style>
        body { font-family: Arial; margin: 0 auto; max-width: 700px; padding: 20px; }
        form { background: #f9f9f9; padding: 20px; border-radius: 8px; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; }
        label { font-weight: bold; }
        .msg { text-align: center; margin-bottom: 10px; }
        .msg p { padding: 10px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <h2>Create New Blog Post</h2>

    <div class="msg">
        <?php if ($success) echo "<p class='success'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    </div>

    <form method="POST" action="">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Content:</label>
        <textarea name="content" rows="6" required></textarea>

        <input type="submit" value="Create Post">
    </form>

</body>
</html>
