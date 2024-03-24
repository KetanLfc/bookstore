<?php
header("Content-Type:application/json");
include("bookfunctions.php");

// Validate the API key and check rate limit
$apiKey = $_GET['api_key'] ?? '';
if (!$apiKey || !isValidApiKey($apiKey)) {
    deliver_response(403, 'Forbidden: Invalid or Unapproved API Key', NULL, $_GET['format'] ?? 'json');
    exit();
}

$apiKeyId = getApiKeyID($apiKey);
if (!canMakeRequest($apiKeyId)) {
    deliver_response(429, 'Too Many Requests: Rate limit exceeded', NULL, $_GET['format'] ?? 'json');
    exit();
}

// Function to validate the API key
function isValidApiKey($apiKey) {
    $conn = getDbConnection();
    $query = "SELECT user_id FROM api_keys WHERE api_key = ? AND is_approved = TRUE";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $apiKey);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $isValid = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_close($conn);
    return $isValid;
}

// Log the API request
logApiRequest($apiKeyId);

// Function to deliver response in either JSON or XML format
function deliver_response($status, $statusMessage, $data, $format = 'json'){
    if (strtolower($format) == 'xml') {
        // Respond in XML format
        header('Content-Type: application/xml; charset=utf-8');
        $xml = new SimpleXMLElement('<response/>');
        $xml->addChild('status', $status);
        $xml->addChild('status_message', $statusMessage);
        array_to_xml($data, $xml->addChild('data'));
        echo $xml->asXML();
    } else {
        // Default response in JSON format
        header('Content-Type: application/json; charset=utf-8');
        $response = [
            'status' => $status,
            'status_message' => $statusMessage,
            'data' => $data
        ];
        echo json_encode($response, JSON_UNESCAPED_SLASHES);
    }
}

// Convert array to XML
function array_to_xml($data, &$xml_data) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

// Main API logic
$format = $_GET['format'] ?? 'json'; // Default response format is JSON

// Handle request based on provided parameters
if (!empty($_GET['title'])) {
    $books = getBooksByTitle($_GET['title']);
    deliver_response(200, empty($books) ? 'No Books Found' : 'Books found', $books, $format);
} elseif (!empty($_GET['author'])) {
    $books = getBooksByAuthor($_GET['author']);
    deliver_response(200, empty($books) ? 'No Books Found' : 'Books found', $books, $format);
} elseif (!empty($_GET['pub_year'])) {
    $books = getBooksByYear($_GET['pub_year']);
    deliver_response(200, empty($books) ? 'No Books Found' : 'Books found', $books, $format);
} elseif (!empty($_GET['category'])) {
    $books = getBooksByCategory($_GET['category']);
    deliver_response(200, empty($books) ? 'No Books Found' : 'Books found', $books, $format);
} elseif (!empty($_GET['author']) && !empty($_GET['category'])) {
    $books = getBooksByAuthorAndCategory($_GET['author'], $_GET['category']);
    deliver_response(200, empty($books) ? 'No Books Found' : 'Books found', $books, $format);
} elseif (!empty($_GET['author']) && !empty($_GET['pub_year'])) {
    $books = getBooksByAuthorAndYear($_GET['author'], $_GET['pub_year']);
    deliver_response(200, empty($books) ? 'No Books Found' : 'Books found', $books, $format);
} else {
    deliver_response(400, 'Bad Request', null, $format);
}
?>
