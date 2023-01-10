<?php
function openConnection()
{
    $host = "localhost";
    $dbUser = "root";
    $dbPassword = "superadmin";
    $db = "store";

    $conn = new mysqli($host, $dbUser, $dbPassword, $db);
    if ($conn->connect_error) {
        error_log('Connection error: ' . $conn->connect_error);
        exit();
    }
    return $conn;
}

$conn = openConnection();



