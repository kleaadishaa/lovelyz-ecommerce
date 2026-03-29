<?php
// Copy this file, rename it to db.php, and fill in your own credentials.
// cp includes/db.example.php includes/db.php

$host = 'localhost';
$dbname = 'lovelyz_db';   // your database name
$username = 'root';        // your MySQL username
$password = '';            // your MySQL password

// the values are just examples 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
