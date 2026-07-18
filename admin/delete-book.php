<?php

include "../config/database.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {

    header("Location: books.php");
    exit();

}

$id = (int) $_GET['id'];

// Check Book

$check = mysqli_query($conn, "SELECT * FROM books WHERE id='$id'");

if (mysqli_num_rows($check) == 0) {

    header("Location: books.php");
    exit();

}

// Delete Book

mysqli_query($conn, "DELETE FROM books WHERE id='$id'");

header("Location: books.php?deleted=1");
exit();

?>
include "../includes/admin-header.php";

