<?php
require 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    die("Unauthorized access. Please <a href='login.php'>Login</a>.");
}

if (!isset($_GET['id'])) {
    die("No post ID specified.");
}

$post_id = intval($_GET['id']);
$username = $_SESSION['username'];


$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Post not found.");
}

$post = $result->fetch_assoc();


if ($post['username'] !== $username) {
    die("You are not authorized to edit this post.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $content = $conn->real_escape_string($_POST["content"]);

    $update_sql = "UPDATE posts SET title=?, content=? WHERE id=? AND username=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssis", $title, $content, $post_id, $username);

    if ($update_stmt->execute()) {
        echo "<p>✅ Post updated successfully. <a href='list_posts.php'>Back to list</a></p>";
        exit();
    } else {
        echo "❌ Error updating post: " . $update_stmt->error;
    }
}
?>


<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    padding-top: 50px;
}

.edit-container {
    background-color: #ffffff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
}

.edit-container h2 {
    text-align: center;
    color: #333333;
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #444;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    transition: border 0.3s ease;
}

input[type="text"]:focus,
textarea:focus {
    border-color: #007bff;
    outline: none;
}

input[type="submit"] {
    background-color: #007bff;
    color: white;
    font-size: 16px;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

p.success {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 6px;
    text-align: center;
}

p.error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 6px;
    text-align: center;
}

</style>

<form method="post" action="">
    <h2>Edit Post</h2>
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

    <label>Content:</label>
    <textarea name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>

    <input type="submit" value="Update Post">
</form>
