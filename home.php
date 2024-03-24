<?php
$servername = "localhost"; 
$username = "Ketan";
$password = "ketan8ram";
$dbname = "bookstore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch books data
$sql = "SELECT title, author, cover_photo, reviews FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Book Den</title>
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
    #info{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
        grid-column-gap: 10px;
        grid-row-gap: 10px;
    }
    #info img{
        width: 100%;
    }
    #info img:hover{
        border-top-left-radius: 50px;
    }
    .img{
        box-sizing: border-box;
        box-shadow: 12px 10px 12px rgba(0, 0, 0, 0.5);
    }
    .img:hover{
        box-shadow: none;
        background-color: #fff;
        border-bottom-right-radius: 50px;
        border-top-left-radius: 50px;
    }
    
    @media (max-width: 710px){
        .navbar-brand {
            font-size: 15px;
            top:20px;
            left:15px;
        }
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
    <br>
    <br>
    <br>
    <br>
    <h1 id="our">Your ultimate destination for exploring and discovering books across a multitude of genres</h1>

    <div id="info">
        <?php
       if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<div class="img">';
            echo '<img src="'.$row["cover_photo"].'" alt="Cover">';
            echo '<div class="img-desc">';
            echo '<h4>'.$row["title"].'</h4>';
            echo '<p>'.$row["author"].'</p>';
            echo '<p><i>"'.$row["reviews"].'"</i></p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }
    $conn->close();
        ?>
    </div>
<br><br>
    <div class="footer">
    &copy; 2024 The Book Den | <a href="#" style="color: #fff;">Privacy Policy</a> | <a href="#" style="color: #fff;">Terms of Use</a>
</div>
</body>
</html>

