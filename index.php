<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="src/output.css">
</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- Left Section (Gradient TANPA BLUR) -->
    <aside class="hidden md:flex w-1/2 items-center justify-center
        bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 rounded-r-4xl">

        <div class="text-white px-12">
            <h1 class="text-4xl font-bold mb-4 leading-tight text-white">
                SIMMA
            </h1>
            <p class="text-blue-200 text-lg max-w-md">
                Student Management System
            </p>
        </div>
    </aside>

    <!-- Right Section (Login Form) -->
    <main class="flex-1 flex items-center justify-center px-6">
        <div
            class="w-full max-w-md bg-white rounded-2xl p-8
                   shadow-xl hover:shadow-2xl transition duration-300">

            <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
                Login Admin
            </h2>
            <p class="text-gray-500 text-sm text-center mb-8">
                Masuk untuk mengelola data mahasiswa
            </p>

            <form action="auth/login.php" method="POST" class="space-y-5">

                <!-- Username -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Username
                    </label>
                    <input
                        type="text"
                        name="username"
                        required
                        class="w-full rounded-lg px-4 py-2
                               border border-gray-300
                               focus:outline-none focus:ring-2 focus:ring-blue-600
                               focus:border-blue-600
                               hover:border-blue-400
                               shadow-sm hover:shadow-md
                               transition"
                        placeholder="Masukkan username">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg px-4 py-2
                               border border-gray-300
                               focus:outline-none focus:ring-2 focus:ring-blue-600
                               focus:border-blue-600
                               hover:border-blue-400
                               shadow-sm hover:shadow-md
                               transition"
                        placeholder="Masukkan password">
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    name="login"
                    class="w-full py-2.5 rounded-lg font-semibold text-white
                           bg-gradient-to-r from-blue-800 to-blue-700
                           shadow-lg hover:shadow-xl
                           hover:from-blue-700 hover:to-blue-600
                           transition duration-300
                           transform hover:-translate-y-0.5">
                    Login
                </button>
            </form>

            <p class="text-xs text-gray-400 text-center mt-8">
                © 2026 Sistem CRUD Mahasiswa
            </p>
        </div>
    </main>

</body>
</html>
