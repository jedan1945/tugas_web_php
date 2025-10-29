<?php
$host = "localhost";
$user = "root"; // default Laragon
$pass = "";     // password biasanya kosong
$dbname = "crud_sederhana"; // nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . htmlspecialchars($conn->connect_error));
}
?>
