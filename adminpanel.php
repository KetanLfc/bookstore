<?php
session_start();
include('bookfunctions.php'); 

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: adminlogin.php");
    exit;
}

// Check if the user is logged in as admin
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];
if (!$isAdmin) {
    header("Location: adminlogin.php");
    exit;
}

function approveOrRejectApiKey($apiKeyId, $action) {
    $conn = getDbConnection();
    $isApproved = $action === 'approve' ? TRUE : FALSE; 
    $query = "UPDATE api_keys SET is_approved = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $isApproved, $apiKeyId);
    if (mysqli_stmt_execute($stmt)) {
        echo $action === 'approve' ? "API Key approved successfully." : "API Key rejected.";
    } else {
        echo "Error updating API Key.";
    }
    mysqli_close($conn);
}

// Handling approve/reject actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    approveOrRejectApiKey($_POST['apiKeyId'], $_POST['action']);
}

function fetchApiKeys() {
    $conn = getDbConnection();
    $query = "SELECT * FROM api_keys WHERE is_approved = FALSE";
    $result = mysqli_query($conn, $query);
    $apiKeys = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
    return $apiKeys;
} 
// Fetch API keys to display
$apiKeys = fetchApiKeys();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - The Book Den</title>
    <style>
    body{
        background-color:  #04282c;
        font-family:  'Playfair Display', serif;
        color: white;
    }
    .topnav {
        overflow: hidden;
        background-color: transparent;
        position: absolute;
        top: 20px;
        right: 80px;
    }
    .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }
    .topnav a:hover {
        background-color: rgb(32, 189, 220);
        color: black;
    }
    .topnav a.active {
        background-color: #27b7de;
        color: white;
    }
    .navbar-brand {
        color: rgba(255, 192, 167, 0.932);
        font-size: 30px;
        font-family: Georgia, 'Times New Roman', Times, serif;
        letter-spacing: 2px;
        position: absolute;
        top: 0px;
        left: 0px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        text-align: left;
        padding: 8px;
        color: white;
    }
    tr:nth-child(even) {background-color: #04282c; color: white;}
    .footer {
        margin-top: 20px;
        text-align: center;
        color: white;
    }
    </style>
</head>
<body>
<div class="navbar">
    <p class="navbar-brand" href="#">The Book Den</p>
    <div class="topnav" id="myTopnav">
        <a href="./home.php">Home</a>
        <a href="./apiInterface.php">Users</a>
        <a href="./adminpanel.php" class="active">Admin</a>
    </div>
</div>
<br><br><br><br>
<h1 style="text-align: center;">Admin Panel - API Key Management</h1>

<section>
    <h2>API Key Requests</h2>
    <?php if (!empty($apiKeys)): ?>
    <table>
        <thead>
            <tr>
                <th>API Key</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apiKeys as $key): ?>
            <tr>
                <td><?= htmlspecialchars($key['api_key']) ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="apiKeyId" value="<?= htmlspecialchars($key['id']) ?>">
                        <button type="submit" name="action" value="approve">Approve</button>
                        <button type="submit" name="action" value="reject">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
            <p>No pending API key requests.</p>
        <?php endif; ?>
    </section>
    <br><br><br>
    <section>
        <h2>API Usage Statistics</h2>
        <!-- Display API usage statistics -->
    </section>
   <br><br><br>
    <section>
        <h2>User Management</h2>
        <!-- Provide user management -->
    </section>
    <br><br><br><br><br><br>
    <a href="?logout=1">Logout</a>
    <div class="footer">
    &copy; 2024 The Book Den | <a href="#" style="color: #fff;">Privacy Policy</a> | <a href="#" style="color: #fff;">Terms of Use</a>
</div>
    </body>
</html>
