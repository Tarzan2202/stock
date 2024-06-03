<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>test</title>
</head>
<body>
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
        form {
    margin: 20px auto;
    padding: 20px;
    width: 300px;
    background-color: #f2f2f2;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#passwordMatch {
    margin-bottom: 10px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

    </style>
</head>
<body>
   <div class="navbar">
        <a href="index.php" onclick="loadPage('login.php')">login</a>
        <a href="register.php" onclick="loadPage('register.php')">register</a>
    </div>
    <div id="content"></div>
    <h2 style="text-align: center;">Register</h2>
    <form action="#" method="POST" >
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required oninput='checkPasswordMatch();'><br>
        <div id="passwordMatch"></div>
        <button type="submit" id="registerBtn" disabled>Register</button>
    </form>
</body>
</html>
<script>
    function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var confirm_password = document.getElementById("confirm_password").value;

        if (password != confirm_password) {
            document.getElementById("passwordMatch").innerHTML = "Passwords do not match!";
            document.getElementById("registerBtn").disabled = true;
        } else {
            document.getElementById("passwordMatch").innerHTML = "";
            document.getElementById("registerBtn").disabled = false;
        }
    }
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && $_POST['password'] === $_POST['confirm_password']) {
        $username_reg = $_POST['username'];
        $password_reg = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            $conn_reg = new PDO("mysql:host=localhost;dbname=stock", "root", "");
            $conn_reg->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql_reg = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt_reg = $conn_reg->prepare($sql_reg);
            $stmt_reg->bindParam(':username', $username_reg);
            $stmt_reg->bindParam(':password', $password_reg);

            if ($stmt_reg->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: Unable to register.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Passwords do not match or Please fill in all fields.";
    }
}
?>
