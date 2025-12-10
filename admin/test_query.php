<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conn.php';
include 'session.php';

echo "<h1>Debug Test Page</h1>";

echo "<h2>Session Info:</h2>";
echo "Session Status: " . (isset($_SESSION['loggedin']) ? "Logged in" : "Not logged in") . "<br>";
echo "Username: " . (isset($_SESSION['username']) ? $_SESSION['username'] : "N/A") . "<br>";
echo "Session ID: " . session_id() . "<br>";

echo "<h2>Database Connection:</h2>";
if($conn) {
    echo "Connection: OK<br>";
    echo "Host: " . mysqli_get_host_info($conn) . "<br>";
} else {
    echo "Connection: FAILED - " . mysqli_connect_error() . "<br>";
}

echo "<h2>Query Test:</h2>";
$sql = "SELECT * FROM contact_query ORDER BY query_date DESC";
$result = mysqli_query($conn, $sql);

if($result) {
    $count = mysqli_num_rows($result);
    echo "Query executed successfully<br>";
    echo "Number of rows: {$count}<br><br>";
    
    if($count > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Number</th><th>Message</th><th>Date</th><th>Status</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['query_id'] . "</td>";
            echo "<td>" . $row['query_name'] . "</td>";
            echo "<td>" . $row['query_mail'] . "</td>";
            echo "<td>" . $row['query_number'] . "</td>";
            echo "<td>" . substr($row['query_message'], 0, 50) . "</td>";
            echo "<td>" . $row['query_date'] . "</td>";
            echo "<td>" . ($row['query_status'] ? $row['query_status'] : 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "Query FAILED: " . mysqli_error($conn) . "<br>";
}

echo "<br><br><a href='query.php'>Go to Query Page</a> | <a href='dashboard.php'>Dashboard</a>";
?>
