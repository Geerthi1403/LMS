<?php

include "../config/database.php";
include "../includes/student-header.php";


$student_id = $_SESSION['id'];


// Total Issued Books

$issued = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total 
    FROM issue_books
    WHERE student_id='$student_id'
    AND status='issued'
    "
);

$totalIssued = mysqli_fetch_assoc($issued)['total'];



// Pending Requests

$requests = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM book_requests
    WHERE student_id='$student_id'
    AND status='pending'
    "
);

$totalRequests = mysqli_fetch_assoc($requests)['total'];



// Approved Requests

$approved = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM book_requests
    WHERE student_id='$student_id'
    AND status='approved'
    "
);

$totalApproved = mysqli_fetch_assoc($approved)['total'];



// Fine Amount

$fine = mysqli_query(
    $conn,
    "
    SELECT SUM(amount) AS total
    FROM fines
    WHERE student_id='$student_id'
    AND status='unpaid'
    "
);


$totalFine = mysqli_fetch_assoc($fine)['total'];


if($totalFine == null){

    $totalFine = 0;

}




// Recent Issued Books

$recentBooks = mysqli_query(
    $conn,
    "
    SELECT 

    books.book_name,
    books.authors,

    issue_books.issue_date,
    issue_books.expected_return_date,
    issue_books.return_date,
    issue_books.status


    FROM issue_books


    JOIN books

    ON issue_books.book_id = books.id


    WHERE issue_books.student_id='$student_id'


    ORDER BY issue_books.id DESC


    LIMIT 5

    "
);






// Recent Pending Requests

$recentRequests = mysqli_query(
    $conn,
    "
    SELECT

    books.book_name,
    books.authors,

    book_requests.status,
    book_requests.created_at


    FROM book_requests


    JOIN books

    ON book_requests.book_id = books.id


    WHERE book_requests.student_id='$student_id'


    AND book_requests.status='pending'


    ORDER BY book_requests.id DESC


    LIMIT 5

    "
);



?>



<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8">

Student Dashboard

</h1>






<!-- Cards -->


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">



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

Pending Requests

</h3>


<p class="text-3xl font-bold mt-3">

<?= $totalRequests ?>

</p>


</div>






<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Approved Requests

</h3>


<p class="text-3xl font-bold mt-3">

<?= $totalApproved ?>

</p>


</div>






<div class="bg-white shadow rounded-2xl p-6">

<h3 class="text-gray-500">

Unpaid Fine

</h3>


<p class="text-3xl font-bold mt-3">

Rs. <?= $totalFine ?>

</p>


</div>




</div>








<!-- Recent Issued Books -->


<div class="mt-12 bg-white shadow rounded-2xl p-6">



<h2 class="text-2xl font-bold mb-5">

Recent Issued Books

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
Issue Date
</th>


<th class="p-3">
Return Before
</th>


<th class="p-3">
Status
</th>


<th class="p-3">
Return Date
</th>


</tr>


</thead>





<tbody>




<?php if(mysqli_num_rows($recentBooks)>0){ ?>



<?php while($row=mysqli_fetch_assoc($recentBooks)){ ?>



<tr class="border-b">



<td class="p-3">

<?= htmlspecialchars($row['book_name']) ?>

</td>




<td class="p-3">

<?= htmlspecialchars($row['authors']) ?>

</td>





<td class="p-3">

<?= htmlspecialchars($row['issue_date']) ?>

</td>





<td class="p-3">

<?= htmlspecialchars($row['expected_return_date'] ?? '-') ?>

</td>





<td class="p-3">


<?php if($row['status']=="issued"){ ?>


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Issued

</span>


<?php }else{ ?>


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Returned

</span>


<?php } ?>


</td>





<td class="p-3">

<?= htmlspecialchars($row['return_date'] ?? '-') ?>

</td>





</tr>



<?php } ?>



<?php }else{ ?>



<tr>

<td colspan="6"

class="text-center p-10 text-gray-500">

No Issued Books Found

</td>

</tr>



<?php } ?>




</tbody>



</table>


</div>



</div>










<!-- Recent Pending Requests -->


<div class="mt-10 bg-white shadow rounded-2xl p-6">



<h2 class="text-2xl font-bold mb-5">

Recent Pending Requests

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
Requested Date
</th>


<th class="p-3">
Status
</th>


</tr>


</thead>





<tbody>




<?php if(mysqli_num_rows($recentRequests)>0){ ?>



<?php while($req=mysqli_fetch_assoc($recentRequests)){ ?>



<tr class="border-b">



<td class="p-3">

<?= htmlspecialchars($req['book_name']) ?>

</td>




<td class="p-3">

<?= htmlspecialchars($req['authors']) ?>

</td>





<td class="p-3">

<?= htmlspecialchars($req['created_at']) ?>

</td>





<td class="p-3">


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

<?= htmlspecialchars($req['status']) ?>

</span>


</td>




</tr>




<?php } ?>




<?php }else{ ?>



<tr>


<td colspan="4"

class="text-center p-10 text-gray-500">


No Pending Requests Found


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