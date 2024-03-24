<?php
session_start();
include('bookfunctions.php');

function loginUser($username, $email, $apiKey) {
    $conn = getDbConnection();
    // Check if user and API key match and are approved
    $query = "SELECT u.id, u.username, a.api_key, a.is_approved FROM users u INNER JOIN api_keys a ON u.id = a.user_id WHERE u.username = ? AND u.email = ? AND a.api_key = ? AND a.is_approved = TRUE";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $apiKey);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($user = mysqli_fetch_assoc($result)) {
        // User found and API key is approved
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['api_key'] = $user['api_key'];
        header("Location: search.php"); // Redirect to search page
        exit;
    } else {
        echo "Invalid login or your API key is not approved yet.";
    }
    mysqli_close($conn);
}

// Handling POST request for user login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    loginUser($_POST['username'], $_POST['email'], $_POST['apiKey']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - The Book Den</title>
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
            width: 50%;
            margin: auto;
            padding-top: 20px;
        }
        form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
            color: black;
        }
        input[type=text], input[type=email] {
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
    </style>
</head>
<body>

<div class="navbar">
    <a href="./home.php">Home</a>
    <a href="./apiInterface.php">Users</a>
    <a href="./adminpanel.php">Admin</a>
</div>

<div class="container">
    <h2>User Login</h2>
    <!-- User Login Form -->
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="apiKey" placeholder="API Key" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

