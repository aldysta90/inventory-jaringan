<?php

error_reporting(E_ALL ^ E_DEPRECATED);
$servername = "localhost";
$username = "u249561804_admin";
$password = "Bismillah15(*)";
$dbname = "u249561804_inventori";

$koneksi = mysqli_connect('localhost', 'u249561804_admin', 'Bismillah15(*)');
$db = mysqli_select_db($koneksi, $dbname);

// Create connection
global $conn;
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
