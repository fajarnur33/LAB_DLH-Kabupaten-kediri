<?php
$conn = new mysqli("localhost", "root", "", "db_koreksi");
if ($conn->connect_error) { die("Koneksi Gagal: " . $conn->connect_error); }
session_start();
?>