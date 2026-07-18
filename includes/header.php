<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="/LMS/assets/css/style.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<nav class="bg-gray-900 text-white shadow-md">

    <div class="max-w-7xl mx-auto px-4 pb-1">

        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="/LMS/index.php" class="flex items-center gap-3">

                <img
                    src="/LMS/assets/images/logo.png"
                    alt="LMS Logo"
                    class="w-11 h-11 rounded-xl object-cover">

                <span class="text-xl font-bold">
                    LMS
                </span>

            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-6">

                <?php if (!isset($_SESSION['username'])): ?>

                    <a href="/LMS/index.php" class="hover:text-blue-400 transition">
                        Home
                    </a>

                    <a href="/LMS/books.php" class="hover:text-blue-400 transition">
                        Books
                    </a>

                    <a href="/LMS/login.php" class="hover:text-blue-400 transition">
                        Login
                    </a>

                    <a href="/LMS/register.php"
                       class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition">
                        Register
                    </a>

                <?php else: ?>

                    <?php if ($_SESSION['role'] == "admin"): ?>

                        <a href="/LMS/admin/dashboard.php" class="hover:text-blue-400 transition">
                            Dashboard
                        </a>

                    <?php else: ?>

                        <a href="/LMS/student/dashboard.php" class="hover:text-blue-400 transition">
                            Dashboard
                        </a>

                    <?php endif; ?>

                    <span class="text-gray-300">
                        Hi, <?= htmlspecialchars($_SESSION['username']) ?>
                    </span>

                    <a href="/LMS/logout.php"
                       class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition">
                        Logout
                    </a>

                <?php endif; ?>

            </div>

            <!-- Mobile Button -->
            <button
                id="menu-btn"
                class="md:hidden text-3xl focus:outline-none"
                type="button">

                ☰

            </button>

        </div>

        <!-- Mobile Menu -->
        <div
            id="mobile-menu"
            class="hidden md:hidden bg-gray-800 rounded-xl mb-4 p-4">

            <?php if (!isset($_SESSION['username'])): ?>

                <a href="/LMS/index.php"
                   class="block px-3 py-3 rounded-lg hover:bg-gray-700">
                    Home
                </a>

                <a href="/LMS/books.php"
                   class="block px-3 py-3 rounded-lg hover:bg-gray-700">
                    Books
                </a>

                <a href="/LMS/login.php"
                   class="block px-3 py-3 rounded-lg hover:bg-gray-700">
                    Login
                </a>

                <a href="/LMS/register.php"
                   class="block mt-2 bg-blue-600 hover:bg-blue-700 text-center px-4 py-3 rounded-lg">
                    Register
                </a>

            <?php else: ?>

                <?php if ($_SESSION['role'] == "admin"): ?>

                    <a href="/LMS/admin/dashboard.php"
                       class="block px-3 py-3 rounded-lg hover:bg-gray-700">
                        Dashboard
                    </a>

                <?php else: ?>

                    <a href="/LMS/student/dashboard.php"
                       class="block px-3 py-3 rounded-lg hover:bg-gray-700">
                        Dashboard
                    </a>

                <?php endif; ?>

                <div class="px-3 py-3 text-gray-300">
                    Hi, <?= htmlspecialchars($_SESSION['username']) ?>
                </div>

                <a href="/LMS/logout.php"
                   class="block mt-2 bg-red-500 hover:bg-red-600 text-center px-4 py-3 rounded-lg">
                    Logout
                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 py-6">

<script>

const menuBtn = document.getElementById("menu-btn");
const mobileMenu = document.getElementById("mobile-menu");

menuBtn.addEventListener("click", function (e) {

    e.stopPropagation();

    mobileMenu.classList.toggle("hidden");

    if (mobileMenu.classList.contains("hidden")) {

        menuBtn.innerHTML = "☰";

    } else {

        menuBtn.innerHTML = "✕";

    }

});

mobileMenu.addEventListener("click", function (e) {

    e.stopPropagation();

});

document.addEventListener("click", function () {

    if (!mobileMenu.classList.contains("hidden")) {

        mobileMenu.classList.add("hidden");

        menuBtn.innerHTML = "☰";

    }

});

window.addEventListener("resize", function () {

    if (window.innerWidth >= 768) {

        mobileMenu.classList.add("hidden");

        menuBtn.innerHTML = "☰";

    }

});

</script>