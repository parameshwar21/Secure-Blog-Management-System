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


$sql = "SELECT * FROM posts WHERE id = ? AND username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $post_id, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("❌ You are not authorized to delete this post or it doesn't exist.");
}


$delete_sql = "DELETE FROM posts WHERE id = ? AND username = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("is", $post_id, $username);

if ($delete_stmt->execute()) {
    header("Location: list_posts.php?msg=Deleted+successfully");
    exit();
} else {
    echo "❌ Error deleting post: " . $delete_stmt->error;
}
?>
