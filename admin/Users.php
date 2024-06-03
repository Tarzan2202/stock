<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "You must be logged in to access this page";
    header("Location: ../index.php");
    exit();
}

$dsn = 'mysql:host=localhost;dbname=stock';
$username = 'root';
$password = '';

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT roles.role_name 
            FROM users 
            LEFT JOIN user_roles ON users.id = user_roles.user_id 
            LEFT JOIN roles ON user_roles.role_id = roles.role_id 
            WHERE users.username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result && $result['role_name'] !== 'Admin') {
        echo "You do not have permission to access this page";
        header("Location: ../index.php");
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['role_id'])) {
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        $checkUserSql = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $conn->prepare($checkUserSql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $userExists = $stmt->fetch();
        if ($userExists) {
            $updateSql = "UPDATE user_roles SET role_id = :role_id WHERE user_id = :user_id";
            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':role_id', $role_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            echo " ";
        } else {
            echo "User not found";
        }
    }
    $sql = "SELECT users.id, users.username, roles.role_name 
            FROM users 
            LEFT JOIN user_roles ON users.id = user_roles.user_id 
            LEFT JOIN roles ON user_roles.role_id = roles.role_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Roles</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="Users.php">Users</a>
        <a href="Products.php">Products</a>
        <a href="../logout.php">Logout</a>
    </div>
    <h2>User Roles</h2>

    <?php
    if (!empty($results)) {
        echo "<table border='1'>";
        echo "<tr><th>Username</th><th>Role</th><th>Action</th></tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['role_name']) . "</td>
                    <td>
                        <form action='' method='POST'>
                            <input type='hidden' name='user_id' value='" . htmlspecialchars($row['id']) . "'>
                            <select name='role_id'>
                                <option value='2' " . ($row['role_name'] == 'User' ? 'selected' : '') . ">User</option>
                                <option value='1' " . ($row['role_name'] == 'Admin' ? 'selected' : '') . ">Admin</option>
                            </select>
                            <button type='submit'>Update</button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }
    ?>
</body>
</html>
