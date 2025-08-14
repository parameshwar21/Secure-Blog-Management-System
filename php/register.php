<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
       header("Location: login.php");
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>


<style>
    
body {
    font-family: Arial, sans-serif;
    background-color: #f0f4f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


form {
    background-color: #ffffff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
}


h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}


input[type="text"],
input[type="password"],
select {
    width: 90%;
    padding: 10px;
    margin: 10px auto;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    display: block;
}


input[type="submit"] {
    width: 95%;
    padding: 10px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 15px;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #218838;
}


.success {
    color: green;
    margin-top: 10px;
}

.error {
    color: red;
    margin-top: 10px;
}


a {
    color: #007bff;
    text-decoration: none;
    font-size: 0.9em;
}

a:hover {
    text-decoration: underline;
}

</style>


<form method="post">
    <h2>Register</h2>
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
