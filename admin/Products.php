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
        <a href="index.php" onclick="loadPage('index.php')">Home</a>
        <a href="Users.php" onclick="loadPage('Users.php')">Users</a>
        <a href="Products.php" onclick="loadPage('Products.php')">Products</a>
        <a href="../logout.php">Logout</a>
    </div>
    <?php
    session_start();
if (isset($_SESSION['username'])) {
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

        if ($result) {
            if ($result['role_name'] === 'Admin') {
            } else {
                echo "You do not have permission to access this page";
                header("Location: ../index.php");
                exit();
            }
        } else {
            echo "User not found";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo "You must be logged in to access this page";
    header("Location: ../index.php");
    exit();
}
?>