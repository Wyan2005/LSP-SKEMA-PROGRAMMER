<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Mahasiswa.php'; // tambahkan model

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Ambil data mahasiswa berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: index.php");
    exit;
}

// Proses update menggunakan OOP
if (isset($_POST['update'])) {

    $mahasiswa = new Mahasiswa($conn);

    $updateData = [
        'nim' => $_POST['nim'],
        'nama' => $_POST['nama'],
        'prodi' => $_POST['prodi'],
        'angkatan' => $_POST['angkatan']
    ];

    $mahasiswa->update($id, $updateData);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-gray-100 min-h-screen flex">

<!-- SIDEBAR -->
<aside class="w-64 bg-white shadow-lg hidden md:flex flex-col">

    <!-- Header Sistem -->
    <div class="px-6 py-4">
        <h1 class="text-xl font-bold text-blue-600">
            SIMMA
        </h1>
        <p class="text-sm text-gray-400">
            Student Management System
        </p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">

        <!-- Dashboard -->
        <a href="../dashboard.php"
           class="group flex items-center gap-3 px-4 py-2 rounded-lg
                  text-gray-700 font-medium
                  transition-all duration-300
                  hover:text-white
                  hover:bg-gradient-to-r hover:from-blue-900 hover:to-blue-800
                  hover:shadow-md
                  transform hover:-translate-y-0.5">

            <svg class="w-5 h-5"
                 fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
            </svg>

            Dashboard
        </a>

        <!-- Data Mahasiswa (AKTIF di Edit) -->
        <a href="index.php"
           class="group flex items-center gap-3 px-4 py-2 rounded-lg
                  text-white font-medium
                  bg-gradient-to-r from-blue-900 to-blue-800
                  shadow-md
                  transition-all duration-300
                  transform hover:-translate-y-0.5">

            <svg class="w-5 h-5"
                 fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.354a4 4 0 110 5.292M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z"/>
            </svg>

            Data Mahasiswa
        </a>

    </nav>

    <!-- Logout -->
    <div class="px-4 py-4">
        <a href="../auth/logout.php"
           class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg
                  text-sm font-medium text-white
                  bg-gradient-to-r from-red-600 to-red-500
                  shadow-sm
                  hover:from-red-500 hover:to-red-400
                  hover:shadow-md
                  transition-all duration-300
                  active:scale-95">

            <svg class="w-4 h-4"
                 fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
            </svg>

            Logout
        </a>
    </div>

</aside>


<!-- MAIN -->
<div class="flex-1 flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-sm px-6 py-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Edit Data Mahasiswa
        </h2>
    </header>

    <!-- CONTENT -->
    <main class="p-6 flex justify-center">

        <div class="bg-white rounded-xl shadow-md p-8 w-full max-w-lg">

            <form method="POST" class="space-y-5">

                <!-- NIM -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">NIM</label>
                    <input type="text" name="nim"
                           value="<?= htmlspecialchars($data['nim']); ?>"
                           required
                           class="w-full rounded-lg px-4 py-2
                                  border border-gray-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-600
                                  hover:border-blue-400
                                  shadow-sm hover:shadow-md transition">
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama Mahasiswa</label>
                    <input type="text" name="nama"
                           value="<?= htmlspecialchars($data['nama']); ?>"
                           required
                           class="w-full rounded-lg px-4 py-2
                                  border border-gray-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-600
                                  hover:border-blue-400
                                  shadow-sm hover:shadow-md transition">
                </div>

                <!-- Prodi -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Program Studi</label>
                    <input type="text" name="prodi"
                           value="<?= htmlspecialchars($data['prodi']); ?>"
                           required
                           class="w-full rounded-lg px-4 py-2
                                  border border-gray-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-600
                                  hover:border-blue-400
                                  shadow-sm hover:shadow-md transition">
                </div>

                <!-- Angkatan -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Angkatan</label>
                    <input type="number" name="angkatan"
                           value="<?= htmlspecialchars($data['angkatan']); ?>"
                           required
                           class="w-full rounded-lg px-4 py-2
                                  border border-gray-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-600
                                  hover:border-blue-400
                                  shadow-sm hover:shadow-md transition">
                </div>

                <!-- BUTTON -->
                <div class="flex justify-between pt-6">

                    <!-- BATAL -->
                    <a href="index.php"
                       class="inline-flex items-center justify-center
                              px-6 py-2 rounded-lg text-white font-medium
                              bg-gradient-to-r from-red-600 to-red-500
                              shadow-md
                              hover:from-red-500 hover:to-red-400
                              hover:shadow-lg
                              transition-all duration-300
                              transform hover:-translate-y-0.5 active:scale-95">
                        Batal
                    </a>

                    <!-- UPDATE -->
                    <button type="submit" name="update"
                            class="inline-flex items-center justify-center
                                   px-6 py-2 rounded-lg text-white font-medium
                                   bg-gradient-to-r from-blue-900 to-blue-800
                                   shadow-md
                                   hover:from-blue-800 hover:to-blue-700
                                   hover:shadow-lg
                                   transition-all duration-300
                                   transform hover:-translate-y-0.5 active:scale-95">
                        Update Data
                    </button>

                </div>

            </form>

        </div>

    </main>
</div>

</body>
</html>
