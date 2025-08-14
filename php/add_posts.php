<?php
require 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    die("Unauthorized access. Please <a href='login.php'>login</a>.");
}

$username = $_SESSION['username'];
$success = "";
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || strlen($title) < 3) {
        $error = "❗ Title must be at least 3 characters.";
    } elseif (empty($content) || strlen($content) < 10) {
        $error = "❗ Content must be at least 10 characters.";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (title, content, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $username);

        if ($stmt->execute()) {
            $success = " Post added successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}


$postQuery = "SELECT * FROM posts ORDER BY created_at DESC";
$posts = $conn->query($postQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            max-width: 900px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
        }

        
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .msg p {
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        li h3 {
            color: #007bff;
            margin: 0 0 10px;
        }

        li p {
            color: #444;
        }

        li small {
            color: #777;
            display: block;
            margin-top: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
            margin-right: 15px;
            font-size: 0.95em;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            margin-top: 15px;
            border: none;
            border-top: 1px solid #ccc;
        }
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

<h2>All Posts</h2>

<?php if ($posts->num_rows > 0): ?>
    <ul>
        <?php while ($row = $posts->fetch_assoc()): ?>
            <li>
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <small>Posted by: <?php echo htmlspecialchars($row['username']); ?></small>
                <small>Posted on: <?php echo $row['created_at']; ?></small>

                <?php if ($row['username'] === $username): ?>
                    <a href="edit_posts.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete_posts.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                <?php endif; ?>

                <hr>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
