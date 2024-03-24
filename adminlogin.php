<?php
session_start();

// Redirect to admin interface if already logged in
if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
    header("Location: adminpanel.php");
    exit;
}

include('bookfunctions.php');
$loginError = '';

// Process login attempt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $conn = getDbConnection();
    $query = "SELECT password, is_admin FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // Verify password and if user is an admin
    if ($user && password_verify($password, $user['password']) && $user['is_admin']) {
        $_SESSION['isAdmin'] = true;
        header("Location: adminpanel.php");
        exit;
    } else {
        $loginError = 'Invalid username or password or not an admin.';
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - The Book Den</title>
    <style>
        body {
            background-color: #04282c;
            font-family: 'Playfair Display', serif;
            color: white;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            width: 40%;
            margin: auto;
            padding-top: 20px;
        }
        form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
            color: black;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        p {
            color: red; /* To make error messages stand out */
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="./home.php">Home</a>
    <a href="./userlogin.php">User Login</a>
    <a href="./adminlogin.php">Admin Login</a>
</div>

<div class="container">
    <h2>Admin Login</h2>
    <form method="POST" autocomplete="off">
        <input type="text" name="username" placeholder="Username" autocomplete="new-password" required>
        <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
        <button type="submit">Login</button>
    </form>
    <?php if ($loginError): ?>
        <p><?= htmlspecialchars($loginError) ?></p>
    <?php endif; ?>
</div>

</body>
</html>

