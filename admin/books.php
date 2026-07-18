<?php

include "../config/database.php";
include "../includes/admin-header.php";

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "
        SELECT *
        FROM books
        WHERE
            book_name LIKE '%$search%'
            OR authors LIKE '%$search%'
            OR department LIKE '%$search%'
            OR edition LIKE '%$search%'
        ORDER BY id DESC
    ";

} else {

    $sql = "
        SELECT *
        FROM books
        ORDER BY id DESC
    ";

}

$result = mysqli_query($conn, $sql);

?>

<div class="py-8 px-2 sm:px-4">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                Manage Books

            </h1>

            <p class="text-gray-500 mt-2">

                View, search, edit and manage all library books.

            </p>

        </div>

        <a
            href="add-book.php"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">

            + Add Book

        </a>

    </div>


    <!-- Search -->

    <div class="bg-white shadow rounded-2xl p-6 mt-8">

        <form method="GET" class="flex flex-col md:flex-row gap-4">

            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                placeholder="Search book, author, department..."
                class="flex-1 border rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button
                class="bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl">

                Search

            </button>

            <?php if ($search != "") { ?>

                <a
                    href="books.php"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl text-center">

                    Clear

                </a>

            <?php } ?>

        </form>

    </div>


    <!-- Table -->

    <div class="bg-white shadow rounded-2xl mt-8 overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">ID</th>

                    <th class="p-4 text-left">Book</th>

                    <th class="p-4 text-left">Author</th>

                    <th class="p-4 text-left">Edition</th>

                    <th class="p-4 text-left">Department</th>

                    <th class="p-4 text-center">Quantity</th>

                    <th class="p-4 text-center">Available</th>

                    <th class="p-4 text-center">Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

            ?>

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4">

                        <?= $row['id'] ?>

                    </td>

                    <td class="p-4 font-semibold">

                        <?= htmlspecialchars($row['book_name']) ?>

                    </td>

                    <td class="p-4">

                        <?= htmlspecialchars($row['authors']) ?>

                    </td>

                    <td class="p-4">

                        <?= htmlspecialchars($row['edition']) ?>

                    </td>

                    <td class="p-4">

                        <?= htmlspecialchars($row['department']) ?>

                    </td>

                    <td class="p-4 text-center">

                        <?= $row['quantity'] ?>

                    </td>

                    <td class="p-4 text-center">

                        <?= $row['available'] ?>

                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-3">

                            <a
                                href="edit-book.php?id=<?= $row['id'] ?>"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">

                                Edit

                            </a>

                            <a
                                href="delete-book.php?id=<?= $row['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this book?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                                Delete

                            </a>

                        </div>

                    </td>

                </tr>

            <?php

                }

            } else {

            ?>

                <tr>

                    <td colspan="8" class="text-center py-10 text-gray-500">

                        No books found.

                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

    </div>

</div>
<?php

include "../includes/footer.php";

?>