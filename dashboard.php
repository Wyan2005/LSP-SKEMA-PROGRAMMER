<?php
session_start();

// Proteksi halaman
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/config/database.php';

$username = $_SESSION['username'] ?? 'Admin';

// Statistik
$totalMahasiswa = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa")
)['total'];

$totalProdi = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(DISTINCT prodi) AS total FROM mahasiswa")
)['total'];

$angkatanTerbaru = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT MAX(angkatan) AS terbaru FROM mahasiswa")
)['terbaru'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="src/output.css">
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
 <aside class="w-64 bg-white shadow-xl hidden md:flex flex-col">

    <!-- Logo / System Name -->
    <div class="px-6 py-6">
        <h1 class="text-2xl font-bold text-blue-800 tracking-wide">
            SIMMA
        </h1>
        <p class="text-sm text-gray-400">
            Student Management System
        </p>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 space-y-2">

        <!-- Dashboard (ACTIVE) -->
        <a href="dashboard.php"
           class="group flex items-center gap-3 px-4 py-2.5 rounded-xl
                  text-white font-medium
                  bg-gradient-to-r from-blue-900 to-blue-800
                  shadow-md
                  transition-all duration-300
                  transform hover:-translate-y-0.5">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
            </svg>

            Dashboard
        </a>

        <!-- Data Mahasiswa -->
        <a href="mahasiswa/index.php"
           class="group flex items-center gap-3 px-4 py-2.5 rounded-xl
                  text-gray-700 font-medium
                  hover:text-white
                  hover:bg-gradient-to-r hover:from-blue-900 hover:to-blue-800
                  hover:shadow-md
                  transition-all duration-300
                  transform hover:-translate-y-0.5">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.354a4 4 0 110 5.292M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z"/>
            </svg>

            Data Mahasiswa
        </a>

    </nav>

    <!-- Logout (SMALL & CLEAN) -->
    <div class="px-4 py-4">
        <a href="../auth/logout.php"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
                  text-sm font-medium text-white
                  bg-gradient-to-r from-red-600 to-red-500
                  shadow-sm
                  hover:shadow-md
                  hover:from-red-500 hover:to-red-400
                  transition-all duration-300
                  active:scale-95">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
            </svg>

            Logout
        </a>
    </div>

</aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">

        <!-- Topbar -->
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Dashboard</h2>

            <!-- Profil Icon -->
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4a4 4 0 100 8 4 4 0 000-8zM6 20a6 6 0 0112 0"/>
                </svg>
                <span class="text-sm font-medium">
                    <?= htmlspecialchars($username); ?>
                </span>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">

            <!-- Welcome -->
           <div
                class="bg-white rounded-xl p-6 mb-6
                    shadow-[0_10px_25px_rgba(0,0,0,0.06)]
                    hover:shadow-[0_18px_40px_rgba(0,0,0,0.12)]
                    transition-all duration-300 ease-out
                    transform hover:-translate-y-1
                    border-t-4 border-blue-800">

                <h3 class="text-2xl font-bold text-gray-800 mb-1">
                    Selamat Datang, <?= htmlspecialchars($username); ?> 👋
                </h3>

                <p class="text-gray-600">
                    Berikut ringkasan data mahasiswa saat ini.
                </p>
            </div>

            <!-- Statistik Cards -->
           <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <!-- Total Mahasiswa -->
    <div
        class="bg-white rounded-xl p-6 flex items-center gap-4
               border-l-4 border-blue-800
               shadow-[0_10px_25px_rgba(0,0,0,0.06)]
               hover:shadow-[0_18px_40px_rgba(0,0,0,0.12)]
               transition-all duration-300 ease-out
               transform hover:-translate-y-1">

        <div class="bg-blue-100 text-blue-700 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.354a4 4 0 110 5.292M15 21H9a3 3 0 01-3-3v-1a6 6 0 0112 0v1a3 3 0 01-3 3z"/>
            </svg>
        </div>

        <div>
            <p class="text-sm text-gray-500">Total Mahasiswa</p>
            <h3 class="text-2xl font-bold text-gray-800">
                <?= $totalMahasiswa; ?>
            </h3>
        </div>
    </div>

    <!-- Total Prodi -->
    <div
        class="bg-white rounded-xl p-6 flex items-center gap-4
               border-l-4 border-green-600
               shadow-[0_10px_25px_rgba(0,0,0,0.06)]
               hover:shadow-[0_18px_40px_rgba(0,0,0,0.12)]
               transition-all duration-300 ease-out
               transform hover:-translate-y-1">

        <div class="bg-green-100 text-green-700 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6V4m0 2a4 4 0 110 8m0-8v8"/>
            </svg>
        </div>

        <div>
            <p class="text-sm text-gray-500">Program Studi</p>
            <h3 class="text-2xl font-bold text-gray-800">
                <?= $totalProdi; ?>
            </h3>
        </div>
    </div>

    <!-- Angkatan Terbaru -->
    <div
        class="bg-white rounded-xl p-6 flex items-center gap-4
               border-l-4 border-purple-600
               shadow-[0_10px_25px_rgba(0,0,0,0.06)]
               hover:shadow-[0_18px_40px_rgba(0,0,0,0.12)]
               transition-all duration-300 ease-out
               transform hover:-translate-y-1">

        <div class="bg-purple-100 text-purple-700 p-3 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10"/>
            </svg>
        </div>

        <div>
            <p class="text-sm text-gray-500">Angkatan Terbaru</p>
            <h3 class="text-2xl font-bold text-gray-800">
                <?= $angkatanTerbaru ?? '-'; ?>
            </h3>
        </div>
    </div>

</div>

        </main>
    </div>

</body>
</html>
