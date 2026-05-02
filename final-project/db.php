<?php
$conn = new mysqli("localhost", "root", "", "php_workshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>