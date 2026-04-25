<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'tododb';
$user = getenv('DB_USER') ?: 'todouser';
$pass = getenv('DB_PASS') ?: 'todopass';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}