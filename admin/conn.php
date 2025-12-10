<?php
// Start output buffering FIRST to catch any accidental output
if (ob_get_level() == 0) ob_start();

// Database configuration for Docker
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'blood_donation';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Connection error: " . mysqli_connect_error());
