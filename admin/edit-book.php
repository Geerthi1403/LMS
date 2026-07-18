<?php

include "../config/database.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {

    header("Location: books.php");
    exit();

}

$id = (int) $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM books WHERE id=$id");

if (mysqli_num_rows($result) == 0) {

    header("Location: books.php");
    exit();

}


$book = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $book_name  = mysqli_real_escape_string($conn, trim($_POST['book_name']));
    $authors    = mysqli_real_escape_string($conn, trim($_POST['authors']));
    $edition    = mysqli_real_escape_string($conn, trim($_POST['edition']));
    $department = mysqli_real_escape_string($conn, trim($_POST['department']));
    $quantity   = (int) $_POST['quantity'];
    $available  = (int) $_POST['available'];

    if (
        empty($book_name) ||
        empty($authors) ||
        empty($edition) ||
        empty($department)
    ) {

        $error = "All fields are required.";

    } elseif ($quantity < 0 || $available < 0) {

        $error = "Quantity cannot be negative.";

    } elseif ($available > $quantity) {

        $error = "Available quantity cannot be greater than total quantity.";

    } else {

        $update = "
            UPDATE books
            SET
                book_name='$book_name',
                authors='$authors',
                edition='$edition',
                department='$department',
                quantity='$quantity',
                available='$available'
            WHERE id='$id'
        ";

        if (mysqli_query($conn, $update)) {

            header("Location: books.php?updated=1");
            exit();

        } else {

            $error = "Failed to update book.";

        }

    }

}
include "../includes/admin-header.php";

?>


<div class="max-w-3xl mx-auto py-8">

    <div class="bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-2">

            Edit Book

        </h1>

        <p class="text-gray-500 mb-8">

            Update the selected book information.

        </p>

        <?php if (isset($error)) { ?>

            <div class="mb-6 bg-red-100 text-red-700 p-4 rounded-xl">

                <?= $error ?>

            </div>

        <?php } ?>

        <form method="POST" class="space-y-6">

            <div>

                <label class="block font-semibold mb-2">

                    Book Name

                </label>

                <input
                    type="text"
                    name="book_name"
                    required
                    value="<?= htmlspecialchars($book['book_name']) ?>"
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>

            <div>

                <label class="block font-semibold mb-2">

                    Author

                </label>

                <input
                    type="text"
                    name="authors"
                    required
                    value="<?= htmlspecialchars($book['authors']) ?>"
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block font-semibold mb-2">

                        Edition

                    </label>

                    <input
                        type="text"
                        name="edition"
                        required
                        value="<?= htmlspecialchars($book['edition']) ?>"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Department

                    </label>

                    <input
                        type="text"
                        name="department"
                        required
                        value="<?= htmlspecialchars($book['department']) ?>"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block font-semibold mb-2">

                        Total Quantity

                    </label>

                    <input
                        type="number"
                        name="quantity"
                        min="0"
                        required
                        value="<?= $book['quantity'] ?>"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Available Quantity

                    </label>

                    <input
                        type="number"
                        name="available"
                        min="0"
                        required
                        value="<?= $book['available'] ?>"
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

            </div>

            <div class="flex gap-4 pt-2">

                <button
                    type="submit"
                    name="update"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold">

                    Update Book

                </button>

                <a
                    href="books.php"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-semibold">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

<?php

include "../includes/footer.php";

?>

