<?php 
DEFINE ('DB_USER', 'Ketan');
DEFINE ('DB_PASSWORD', 'ketan8ram');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'bookstore');

// Function to get database connection
function getDbConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
    return $conn;
}

function getBooksByTitle($title){
    $conn = getDbConnection();
    $title = mysqli_real_escape_string($conn, $title);

    $query = "SELECT * FROM books WHERE title LIKE '%$title%'";
    $result = mysqli_query($conn, $query);

    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}

function getBooksByAuthor($author){
    $conn = getDbConnection();
    $author = mysqli_real_escape_string($conn, $author);

    $query = "SELECT * FROM books WHERE author LIKE '%$author%'";
    $result = mysqli_query($conn, $query);

    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}

function getBooksByYear($year){
    $conn = getDbConnection();
    $year = mysqli_real_escape_string($conn, $year);

    $query = "SELECT * FROM books WHERE pub_year = '$year'";
    $result = mysqli_query($conn, $query);

    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}


function getBooksByCategory($category){
    $conn = getDbConnection();
    $category = mysqli_real_escape_string($conn, $category);

    $query = "SELECT * FROM books WHERE category LIKE '%$category%'";
    $result = mysqli_query($conn, $query);

    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}

function getBooksByAuthorAndCategory($author, $category){
    $conn = getDbConnection();
    $author = mysqli_real_escape_string($conn, $author);
    $category = mysqli_real_escape_string($conn, $category);

    $query = "SELECT * FROM books WHERE author LIKE '%$author%' AND category LIKE '%$category%'";
    $result = mysqli_query($conn, $query);

    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}

function getBooksByAuthorAndYear($author, $year){
    $conn = getDbConnection();
    $author = mysqli_real_escape_string($conn, $author);
    $year = mysqli_real_escape_string($conn, $year);

    $query = "SELECT * FROM books WHERE author LIKE '%$author%' AND pub_year = '$year'";
    $result = mysqli_query($conn, $query);

    $books = [];
    while($row = mysqli_fetch_assoc($result)){
        $books[] = $row;
    }
    mysqli_close($conn);
    return $books;
}

// Implement getApiKeyID to fetch the API Key ID based on the API Key
function getApiKeyID($apiKey) {
    $conn = getDbConnection();
    $query = "SELECT id FROM api_keys WHERE api_key = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $apiKey);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $apiKeyId);
    mysqli_stmt_fetch($stmt);
    mysqli_close($conn);
    return $apiKeyId;
}

function logApiRequest($apiKeyId) {
    $conn = getDbConnection();
    $query = "INSERT INTO api_requests (api_key_id, request_time) VALUES (?, NOW())";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $apiKeyId);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
}

function canMakeRequest($apiKeyId) {
    $conn = getDbConnection();
    $query = "SELECT COUNT(*) as request_count FROM api_requests WHERE api_key_id = ? AND DATE(request_time) = CURDATE()";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $apiKeyId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $requestCount);
    mysqli_stmt_fetch($stmt);
    mysqli_close($conn);
    return $requestCount < 50;
}

?>
