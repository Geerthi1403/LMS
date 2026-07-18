<?php
include "config/database.php";
include "includes/header.php";

// Latest 4 Books
$sql = "SELECT * FROM books ORDER BY id DESC LIMIT 4";
$result = mysqli_query($conn, $sql);
?>

<!-- HERO SECTION -->
<section
    class="relative rounded-2xl overflow-hidden h-[550px] flex items-center justify-center"
    style="
        background-image:url('assets/images/library.png');
        background-size:cover;
        background-position:center;
        background-repeat:no-repeat;
    ">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Content -->
    <div class="relative z-10 text-center text-white px-6 max-w-4xl">

        <h1 class="text-4xl md:text-6xl font-bold leading-tight">
            Welcome to Our Library
        </h1>

        <p class="mt-6 text-lg md:text-xl text-gray-200">
            Our Library Management System provides an easy and efficient way for students
            and administrators to manage books, borrowing requests, book returns, and
            library records through a modern web-based platform.
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-4">

            <a
                href="books.php"
                class="bg-blue-600 hover:bg-blue-700 transition px-6 py-3 rounded-xl font-semibold">

                Browse Books

            </a>

            <a
                href="register.php"
                class="bg-white text-blue-700 hover:bg-gray-200 transition px-6 py-3 rounded-xl font-semibold">

                Student Register

            </a>

        </div>

    </div>

</section>

<!-- FEATURES -->
<section class="mt-20">

    <h2 class="text-3xl font-bold text-center">
        Library Features
    </h2>

    <p class="text-center text-gray-600 mt-3 max-w-2xl mx-auto">
        Explore our library with powerful features designed for both students and administrators.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">

        <!-- Card 1 -->
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 text-center">

            <div class="text-5xl">
                📚
            </div>

            <h3 class="font-bold text-xl mt-4">
                Browse Books
            </h3>

            <p class="text-gray-600 mt-3">
                Search and explore available books quickly using the online catalog.
            </p>

        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 text-center">

            <div class="text-5xl">
                👨‍🎓
            </div>

            <h3 class="font-bold text-xl mt-4">
                Student Portal
            </h3>

            <p class="text-gray-600 mt-3">
                Request books, view issued books, monitor due dates, and manage your profile.
            </p>

        </div>

        <!-- Card 3 -->
        <!-- <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 text-center">

            <div class="text-5xl">
                👨‍💼
            </div>

            <h3 class="font-bold text-xl mt-4">
                Admin Panel
            </h3>

            <p class="text-gray-600 mt-3">
                Manage books, approve requests, monitor students, and maintain library records.
            </p>

        </div> -->

        <!-- Card 4 -->
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 text-center">

            <div class="text-5xl">
                💰
            </div>

            <h3 class="font-bold text-xl mt-4">
                Fine Management
            </h3>

            <p class="text-gray-600 mt-3">
                View overdue books and monitor library fine details efficiently.
            </p>

        </div>

    </div>

</section>

<!-- LATEST BOOKS -->
<section class="mt-20">

    <div class="flex justify-between items-center">

        <h2 class="text-3xl font-bold">
            Latest Books
        </h2>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">

        <?php if(mysqli_num_rows($result) > 0): ?>

            <?php while($row = mysqli_fetch_assoc($result)): ?>

                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                    <div class="p-6">

                        <h3 class="text-xl font-bold">

                            <?= htmlspecialchars($row['book_name']) ?>

                        </h3>

                        <p class="text-gray-500 mt-2">

                            <?= htmlspecialchars($row['authors']) ?>

                        </p>

                        <p class="text-sm text-gray-500 mt-2">

                            Edition :
                            <?= htmlspecialchars($row['edition']) ?>

                        </p>

                        <p class="text-sm text-gray-500">

                            Department :
                            <?= htmlspecialchars($row['department']) ?>

                        </p>

                        <p class="text-sm text-gray-500">

                            Quantity :
                            <?= htmlspecialchars($row['quantity']) ?>

                        </p>

                        <!-- <span class="inline-block mt-5 px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                            <?= htmlspecialchars($row['available']) ?>

                        </span> -->

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="col-span-4 text-center py-10">

                <h3 class="text-2xl font-semibold text-gray-600">
                    No Books Available
                </h3>

            </div>

        <?php endif; ?>

    </div>

    <div class="text-center mt-10">

        <a
            href="books.php"
            class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-3 rounded-xl font-semibold">

            Explore More Books

        </a>

    </div>

</section>

<!-- CTA -->
<section class="mt-20 mb-10 bg-blue-700 rounded-3xl text-white p-12 text-center">

    <h2 class="text-4xl font-bold">
        Ready to Explore Our Library?
    </h2>

    <p class="mt-5 text-lg text-blue-100 max-w-2xl mx-auto">
        Create your student account today and enjoy quick access to books,
        borrowing requests, issue history, and other library services.
    </p>

    <div class="mt-8">

        <a
            href="register.php"
            class="bg-white text-blue-700 hover:bg-gray-200 transition px-8 py-3 rounded-xl font-semibold">

            Register as Student

        </a>

    </div>

</section>

<?php
include "includes/footer.php";
?>