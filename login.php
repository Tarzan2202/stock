<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<div class="navbar">
        <a href="index.php" onclick="loadPage('login.php')">login</a>
        <a href="register.php" onclick="loadPage('register.php')">register</a>
</div>
<body>
    <h2 style="text-align: center;">Login</h2>
    <form action="#" method="POST" style="background-color: lightblue; padding: 20px; width: 300px; margin: 0 auto;">
        <label for="username" style="color: blue;">Username:</label>
        <input type="text" id="username" name="username" required style="border: 1px solid blue; padding: 5px; display: block; margin-bottom: 10px;"><br>
        <label for="password" style="color: blue;">Password:</label>
        <input type="password" id="password" name="password" required style="border: 1px solid blue; padding: 5px; display: block; margin-bottom: 10px;"><br>
        <button type="submit" id="loginBtn" style="background-color: blue; color: white; padding: 5px 10px; border: none; cursor: pointer; display: block; margin: 0 auto;">Login</button>
    </form>
</body>
</html>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=stock", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT users.id, users.username, users.password, roles.role_name 
                FROM users 
                LEFT JOIN user_roles ON users.id = user_roles.user_id 
                LEFT JOIN roles ON user_roles.role_id = roles.role_id 
                WHERE users.username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['role'] = $row['role_name'];

            if ($row['role_name'] === 'Admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: auth.php");
            }
            exit();
        } else {
            echo "Login failed. Invalid username or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>