<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';

// Ambil data mahasiswa
$query = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="../src/output.css">
</head>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">

    <div class="bg-white rounded-xl w-full max-w-sm p-6
                shadow-[0_20px_50px_rgba(0,0,0,0.25)]
                animate-fade-in">

        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            Konfirmasi Hapus
        </h3>

        <p class="text-sm text-gray-600 mb-6">
            Apakah Anda yakin ingin menghapus data mahasiswa ini?
            <br>
            <span class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
        </p>

        <div class="flex justify-end gap-3">

            <!-- Batal -->
            <button
                onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm font-medium rounded-lg
                       bg-gradient-to-r from-gray-300 to-gray-200
                       text-gray-700
                       hover:from-gray-200 hover:to-gray-100
                       shadow hover:shadow-md
                       transition-all duration-300
                       active:scale-95">
                Batal
            </button>

            <!-- Hapus -->
            <a id="confirmDeleteBtn"
               href="#"
               class="px-5 py-2 text-sm font-semibold rounded-lg
                      text-white
                      bg-gradient-to-r from-red-600 to-red-500
                      hover:from-red-500 hover:to-red-400
                      shadow hover:shadow-lg
                      transition-all duration-300
                      transform hover:-translate-y-0.5 active:scale-95">
                Hapus
            </a>

        </div>
    </div>
</div>

<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg hidden md:flex flex-col">

    <!-- System Name -->
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

        <!-- Dashboard -->
        <a href="../dashboard.php"
           class="group flex items-center gap-3 px-4 py-2.5 rounded-lg
                  text-gray-700 font-medium
                  transition-all duration-300
                  hover:text-white
                  hover:bg-gradient-to-r hover:from-blue-900 hover:to-blue-800
                  hover:shadow-md
                  transform hover:-translate-y-0.5">

            <svg class="w-5 h-5 transition-colors duration-300"
                 fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/>
            </svg>

            Dashboard
        </a>

        <!-- Data Mahasiswa (ACTIVE) -->
        <a href="index.php"
           class="group flex items-center gap-3 px-4 py-2.5 rounded-lg
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
           class="flex items-center gap-3 px-4 py-2 rounded-lg
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
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                Data Mahasiswa
            </h2>
            <a href="tambah.php"
            class="inline-flex items-center gap-2
                    text-white text-sm font-medium
                    px-5 py-2.5 rounded-lg
                    bg-gradient-to-r from-blue-800 to-blue-700
                    shadow-md
                    hover:from-blue-700 hover:to-blue-600
                    hover:shadow-lg
                    transition-all duration-300
                    transform hover:-translate-y-0.5 active:scale-95">
                <span class="text-lg leading-none">+</span>
                Tambah Mahasiswa
            </a>
        </header>

        <!-- Content -->
        <main class="p-6">

                            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                    <table class="w-full border-collapse">

                        <!-- THEAD -->
                        <thead class="text-white
                                    bg-gradient-to-r from-blue-900 to-blue-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">NIM</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Prodi</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Angkatan</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <!-- TBODY -->
                        <tbody class="divide-y">
                        <?php if (mysqli_num_rows($query) > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 text-sm text-gray-700"><?= $no++; ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($row['nim']); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($row['nama']); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($row['prodi']); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($row['angkatan']); ?></td>

                                    <!-- AKSI -->
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">

                                            <!-- EDIT -->
                                            <a href="edit.php?id=<?= $row['id']; ?>"
                                            class="inline-flex items-center gap-1
                                                    px-3 py-1.5 text-xs font-medium text-white
                                                    rounded-md
                                                    bg-gradient-to-r from-yellow-500 to-yellow-400
                                                    shadow
                                                    hover:from-yellow-400 hover:to-yellow-300
                                                    hover:shadow-md
                                                    transition-all duration-300
                                                    transform hover:-translate-y-0.5 active:scale-95">

                                                <!-- icon edit -->
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- HAPUS -->
                                            <button
                                                    type="button"
                                                    onclick="openDeleteModal(<?= $row['id']; ?>)"
                                                    class="inline-flex items-center gap-1
                                                        px-3 py-1.5 text-xs font-medium text-white
                                                        rounded-md
                                                        bg-gradient-to-r from-red-600 to-red-500
                                                        shadow
                                                        hover:from-red-500 hover:to-red-400
                                                        hover:shadow-md
                                                        transition-all duration-300
                                                        transform hover:-translate-y-0.5 active:scale-95">

                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Data mahasiswa belum tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>

        </main>
    </div>

</body>
</html>
<script>
    const deleteModal = document.getElementById('deleteModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    function openDeleteModal(id) {
        confirmDeleteBtn.href = 'hapus.php?id=' + id;
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }
</script>