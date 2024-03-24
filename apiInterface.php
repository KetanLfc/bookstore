<?php
include('bookFunctions.php');

function registerUser($username, $email, $password) {
    $conn = getDbConnection();
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Insert user into `users` table
    $userQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $userQuery);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $passwordHash);
    if (mysqli_stmt_execute($stmt)) {
        $userId = mysqli_insert_id($conn); // Get the inserted user ID
        // Generate and insert API key
        $apiKey = bin2hex(random_bytes(16));
        $keyQuery = "INSERT INTO api_keys (user_id, api_key, is_approved) VALUES (?, ?, FALSE)";
        $keyStmt = mysqli_prepare($conn, $keyQuery);
        mysqli_stmt_bind_param($keyStmt, "is", $userId, $apiKey);
        if (mysqli_stmt_execute($keyStmt)){
            $apiKeyId = mysqli_insert_id($conn); // Get the inserted API key ID

            // Insert API request into `api_requests` table
            $requestQuery = "INSERT INTO api_requests (user_id, api_key_id, request_time) VALUES (?, ?, NOW())";
            $requestStmt = mysqli_prepare($conn, $requestQuery);
            mysqli_stmt_bind_param($requestStmt, "ii", $userId, $apiKeyId);
            mysqli_stmt_execute($requestStmt); // Execute the request insert query
        }

        echo "API Key generated: $apiKey. Waiting for admin approval.";
    } else {
        echo "Error registering user.";
    }
    mysqli_close($conn);
}

// Handling POST requests for user registration 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
    registerUser($_POST['username'], $_POST['email'], $_POST['password']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Interface - The Book Den</title>
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
            width: 80%;
            margin: auto;
            padding-top: 20px;
        }
        form {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
            color: black;
        }
        input[type=text], input[type=email], input[type=password] {
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
            color: #f2f2f2; /* Adjusted for visibility against the dark background */
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
    <h2>Register & Request API Key</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register & Request API Key</button>
    </form>
    <!-- Link for already registered users -->
    <p>Already registered? <a href="userlogin.php">Login</a></p>
</div>

</body>
</html>
