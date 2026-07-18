<?php

include "../config/database.php";
include "../includes/admin-header.php";


// Total Students

$students = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM students"
);

$totalStudents = mysqli_fetch_assoc($students)['total'];



// Total Books

$books = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM books"
);

$totalBooks = mysqli_fetch_assoc($books)['total'];



// Issued Books

$issued = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM issue_books WHERE status='issued'"
);

$totalIssued = mysqli_fetch_assoc($issued)['total'];



// Pending Requests

$requests = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM book_requests WHERE status='pending'"
);

$totalRequests = mysqli_fetch_assoc($requests)['total'];



// Total Fine

$fines = mysqli_query(
    $conn,
    "SELECT SUM(amount) AS total FROM fines"
);

$totalFine = mysqli_fetch_assoc($fines)['total'];

if($totalFine == null){
    $totalFine = 0;
}



// Recent Books

$recentBooks = mysqli_query(
    $conn,
    "SELECT * FROM books ORDER BY id DESC LIMIT 5"
);



// Recent Requests

$recentRequests = mysqli_query(
    $conn,
"
SELECT 
book_requests.status,
students.username,
books.book_name

FROM book_requests

JOIN students 
ON book_requests.student_id = students.id

JOIN books
ON book_requests.book_id = books.id

ORDER BY book_requests.id DESC

LIMIT 5
"
);


?>



<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8">

Admin Dashboard

</h1>




<!-- Cards -->


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">


<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Students

</h3>

<p class="text-3xl font-bold mt-3">

<?= $totalStudents ?>

</p>

</div>





<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Books

</h3>

<p class="text-3xl font-bold mt-3">

<?= $totalBooks ?>

</p>

</div>





<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Issued Books

</h3>

<p class="text-3xl font-bold mt-3">

<?= $totalIssued ?>

</p>

</div>





<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Requests

</h3>

<p class="text-3xl font-bold mt-3">

<?= $totalRequests ?>

</p>

</div>





<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Fine

</h3>

<p class="text-3xl font-bold mt-3">

Rs. <?= $totalFine ?>

</p>

</div>


</div>






<!-- Recent Books -->


<div class="mt-12 bg-white shadow rounded-2xl p-6">


<h2 class="text-2xl font-bold mb-5">

Recent Books

</h2>



<div class="overflow-x-auto">


<table class="min-w-full text-left">


<thead class="bg-gray-100">

<tr>

<th class="p-3">
Book
</th>

<th class="p-3">
Author
</th>

<th class="p-3">
Available
</th>

</tr>

</thead>



<tbody>


<?php while($book=mysqli_fetch_assoc($recentBooks)){ ?>


<tr class="border-b">


<td class="p-3">

<?= htmlspecialchars($book['book_name']) ?>

</td>


<td class="p-3">

<?= htmlspecialchars($book['authors']) ?>

</td>


<td class="p-3">

<?= $book['available'] ?>

</td>


</tr>


<?php } ?>


</tbody>


</table>


</div>


</div>






<!-- Recent Requests -->


<div class="mt-10 bg-white shadow rounded-2xl p-6">


<h2 class="text-2xl font-bold mb-5">

Recent Requests

</h2>



<div class="overflow-x-auto">


<table class="min-w-full text-left">


<thead class="bg-gray-100">

<tr>

<th class="p-3">
Student
</th>


<th class="p-3">
Book
</th>


<th class="p-3">
Status
</th>

</tr>

</thead>



<tbody>


<?php while($req=mysqli_fetch_assoc($recentRequests)){ ?>


<tr class="border-b">


<td class="p-3">

<?= htmlspecialchars($req['username']) ?>

</td>


<td class="p-3">

<?= htmlspecialchars($req['book_name']) ?>

</td>


<td class="p-3">

<?= htmlspecialchars($req['status']) ?>

</td>


</tr>


<?php } ?>


</tbody>


</table>


</div>


</div>



</div>



<?php

include "../includes/footer.php";

?>