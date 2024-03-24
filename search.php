<?php
session_start();
include("bookfunctions.php");

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.php");
    exit;
}

// Logout logic
if (isset($_GET['logout'])) {
    // Destroy the session and redirect to home page
    session_destroy();
    header("Location: home.php");
    exit;
}

// Function to create a response box
function createResponseBox($data, $format) {
    if ($format == 'json') {
        header('Content-Type: application/json');
        return json_encode($data);
    } else {
        header('Content-Type: application/xml');
        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
        array_to_xml($data, $xml_data);
        return $xml_data->asXML();
    }
}

// Function to convert array to XML
function array_to_xml($data, &$xml_data) {
    foreach ($data as $key => $value) {
        // Sanitize key to ensure it's a valid XML tag name
        $key = preg_replace('/[^a-zA-Z0-9_\-]/', '', $key); // Remove characters not allowed in XML names
        if (is_numeric($key[0])) {
            $key = 'item' . $key; // Prefix numerical keys to make them valid
        }

        if (is_array($value)) {
            if (!is_numeric($key)) {
                $subnode = $xml_data->addChild("$key");
                array_to_xml($value, $subnode);
            } else { // If the key is numeric, use a generic 'item' element
                $subnode = $xml_data->addChild("item");
                array_to_xml($value, $subnode);
            }
        } else {
            if (!is_numeric($key)) {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            } else { // If the key is numeric, use a generic 'item' element
                $xml_data->addChild("item", htmlspecialchars("$value"));
            }
        }
    }
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $category = $_POST['category'] ?? '';
    $year = $_POST['year'] ?? '';
    $format = $_POST['format'] ?? 'json';

    // Call the appropriate function based on input
    $books = [];
    if (!empty($title)) {
        $books = getBooksByTitle($title);
    } elseif (!empty($author)) {
        $books = getBooksByAuthor($author);
    } elseif (!empty($category)) {
        $books = getBooksByCategory($category);
    } elseif (!empty($year)) {
        $books = getBooksByYear($year);
    }

    // Create the response box with the data in the requested format
    $response = createResponseBox($books, $format);
    echo $response;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <style>
       body{
        background-color:  #04282c;
        font-family:  'Playfair Display', serif;
    }
    
    #our{
        text-align: center;
        font-size: 30px;
        color: white;
    }
    .topnav {
        overflow: hidden;
        background-color: transparent;
        position:absolute;
        top:20px;
        right:80px;
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
    
    .topnav .icon {
        display: none;
    }
    
    @media screen and (max-width: 630px) {
        .topnav.responsive {position: absolute; right: 1px; top: 1px;}
        
        .topnav.responsive .icon {
            position: absolute;
            right: 1px;
            top: 1px;
        }
        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
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

form label, form input, form select {
    display: block;
    margin: 10px auto;
    font-size: 20px; /* Increased font size */
}

form input, form select {
    width: 30%; 
    padding: 5px;
    margin-bottom: 20px; /* Spacing between fields */
}

/* Style for the response box */
#responseBox {
    margin: 20px auto;
    padding: 20px;
    width: 60%;
    background-color: white;
    color: black;
    text-align: left;
    display: none; /* Hide the box until there is content to show */
    overflow: auto; 
}
input[type="submit"], input[type="reset"] {
    padding: 5px 10px; /* Adjust padding to make buttons smaller */
    margin: 10px 5px; /* Add margin for spacing */
    background-color: #27b7de; /* Button color */
    color: white; /* Text color */
    border: none; /* Remove border */
    cursor: pointer; /* Cursor to indicate clickable */
}

form input[type="submit"], form input[type="reset"] {
    display: inline-block; /* Align buttons side by side */
}
.button-container {
    text-align: center; /* Center-align the container */
    margin-top: 20px; /* Spacing from the form fields */
}
    </style>
</head>
<body>
<div class="navbar">
    <p class="navbar-brand" href="#">The Book Den</p>
    <div class="topnav" id="myTopnav">
        <a href="./home.php">Home</a>
        <a href="./apiInterface.php">Users</a>
        <a href="./adminpanel.php">Admin</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</div>

<br><br><br><br>

<div style="text-align: center;">
    <h1>Search for Books</h1>
    <form action="search.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title"><br>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author"><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category"><br>

        <label for="year">Year:</label>
        <input type="text" id="year" name="year"><br>

        <label for="format">Response Format:</label>
        <select name="format" id="format">
            <option value="json">JSON</option>
            <option value="xml">XML</option>
        </select><br>
        <div class="button-container">
        <input type="submit" value="Search">
        <input type="reset" value="Clear">
</div>
    </form>
</div>

<div id="responseBox" style="margin-top: 20px; text-align: center;">
   
</div>


<script>

//javascript handling to display response in responseBox

</script>


</body>
</html>
