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
<body>
    <div class="navbar">
        <a href="index.php">login</a>
        <a href="register.php">register</a>
    </div>
    <h2 style="text-align: center;">Login</h2>
    <form id="loginForm" style="background-color: lightblue; padding: 20px; width: 300px; margin: 0 auto;">
        <label for="username" style="color: blue;">Username:</label>
        <input type="text" id="username" name="username" required style="border: 1px solid blue; padding: 5px; display: block; margin-bottom: 10px;">
        <label for="password" style="color: blue;">Password:</label>
        <input type="password" id="password" name="password" required style="border: 1px solid blue; padding: 5px; display: block; margin-bottom: 10px;">
        <button type="submit" id="loginBtn" style="background-color: blue; color: white; padding: 5px 10px; border: none; cursor: pointer; display: block; margin: 0 auto;">Login</button>
    </form>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            const response = await fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = result.role === 'Admin' ? 'admin/index.php' : 'auth.php';
            } else {
                alert('Login failed. Invalid username or password.');
            }
        });
    </script>
</body>
</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    try {
        $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME');
        $db_user = getenv('DB_USER');
        $db_pass = getenv('DB_PASS');
        
        $conn = new PDO($dsn, $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT users.id, users.username, users.password, roles.role_name 
                FROM users 
                LEFT JOIN user_roles ON users.id = user_roles.user_id 
                LEFT JOIN roles ON user_roles.role_id = roles.role_id 
                WHERE users.username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['role'] = $row['role_name'];
            $_SESSION['token'] = bin2hex(random_bytes(32));

            header("Location: " . ($row['role_name'] === 'Admin' ? "admin/index.php" : "auth.php"));
            exit();
        } else {
            echo "Login failed. Invalid username or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>