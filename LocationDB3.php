<?php
$servername = "HostName";
$username = "UserName";
$password = "password";
$dbname = "Location";

$path = $_SERVER['PATH_INFO'];
$arr = explode('/',$path);

$ip = $arr[1];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "SELECT * FROM `IP2LOCATION-LITE-DB3` WHERE (INET_ATON('$ip') BETWEEN StartIP AND EndIP)";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
        header('Content-Type: application/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo "<Response>" . "\n";
     // output data of each row
     while($row = $result->fetch_assoc()) {
        echo "<IP>" . $ip . "</IP>" . "\n";
        echo "<CountryCode>" . preg_replace('/\s+/', '', $row["CountryCode"]) . "</CountryCode>" . "\n";
        echo "<Province>" . preg_replace('/\s+/', '', $row["Province"]) . "</Province>" . "\n";
        echo "<City>" . preg_replace('/\s+/', '', $row["City"]) . "</City>" . "\n";
     }
echo "</Response>" . "\n";
} else {
     echo "NOT FOUND";
}

$conn->close();
?>