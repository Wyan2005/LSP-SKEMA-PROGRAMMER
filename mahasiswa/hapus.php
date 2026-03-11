<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Mahasiswa.php'; // tambahkan model

// Pastikan parameter id ada
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Gunakan class Mahasiswa
$mahasiswa = new Mahasiswa($conn);
$mahasiswa->hapus($id);

// Kembali ke halaman data mahasiswa
header("Location: index.php");
exit;
?>