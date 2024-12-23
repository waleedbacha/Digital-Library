<?php
$host = "localhost";
$port = "5432"; 
$dbname = "Emanon";
$username = "postgres";
$password = "123";

// Connection string for pg_connect
$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

// Connect to PostgreSQL using pg_connect
$conn = pg_connect($conn_string);

if ($conn) {
    echo "";
} else {
    echo "Connection failed!";
}
?>

