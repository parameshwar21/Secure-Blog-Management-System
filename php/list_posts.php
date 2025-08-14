<?php
session_start();

if (!isset($_SESSION['username'])) {
    die("Unauthorized access. Please <a href='login.php'>login</a>.");
}

$username = $_SESSION['username'];

$host = "localhost";
$user = "root";
$password = "";
$dbname = "blog1";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Posts</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

ul {
    list-style-type: none;
    padding: 0;
    max-width: 800px;
    margin: auto;
}

li {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

li h3 {
    color: #007bff;
    margin: 0 0 10px;
}

li p {
    color: #444;
    line-height: 1.6;
}

li small {
    color: #888;
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

<h2>Blog Posts</h2>

<?php if ($result->num_rows > 0): ?>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
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
