<?php

include "../config/database.php";
include "../includes/student-header.php";


$student_id = $_SESSION['id'];



// Total Fine

$totalQuery = mysqli_query(
    $conn,
    "
    SELECT SUM(amount) AS total
    FROM fines
    WHERE student_id='$student_id'
    "
);


$totalFine = mysqli_fetch_assoc($totalQuery)['total'];


if($totalFine == null){

    $totalFine = 0;

}




// Get Fine Details

$result = mysqli_query(
    $conn,
    "
    SELECT

    fines.late_days,
    fines.amount,
    fines.status,

    books.book_name,
    books.authors


    FROM fines


    JOIN books

    ON fines.book_id = books.id


    WHERE fines.student_id='$student_id'


    ORDER BY fines.id DESC

    "
);


?>


<div class="py-8 px-2 sm:px-4">


<h1 class="text-3xl font-bold text-gray-800 text-center">

My Fine Details

</h1>


<p class="text-center text-gray-600 mt-3">

View your overdue fine information.

</p>





<!-- Total Fine Card -->


<div class="max-w-md mx-auto mt-10">


<div class="bg-white shadow rounded-2xl p-6 text-center">


<h3 class="text-gray-500 text-lg">

Total Fine

</h3>


<p class="text-4xl font-bold text-red-600 mt-3">

Rs. <?= $totalFine ?>

</p>


</div>


</div>







<!-- Fine Table -->


<div class="bg-white shadow rounded-2xl p-6 mt-10">


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

Late Days

</th>


<th class="p-3">

Amount

</th>


<th class="p-3">

Status

</th>


</tr>


</thead>




<tbody>




<?php if(mysqli_num_rows($result)>0): ?>



<?php while($row=mysqli_fetch_assoc($result)): ?>



<tr class="border-b">



<td class="p-3">

<?= htmlspecialchars($row['book_name']) ?>

</td>




<td class="p-3">

<?= htmlspecialchars($row['authors']) ?>

</td>





<td class="p-3">

<?= htmlspecialchars($row['late_days']) ?>

Days

</td>





<td class="p-3">

Rs. <?= htmlspecialchars($row['amount']) ?>

</td>





<td class="p-3">


<?php if($row['status']=="paid"): ?>


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Paid

</span>



<?php else: ?>


<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Unpaid

</span>



<?php endif; ?>


</td>




</tr>



<?php endwhile; ?>



<?php else: ?>


<tr>

<td colspan="5"
class="text-center p-10 text-gray-500">

No Fine Records Found

</td>

</tr>


<?php endif; ?>



</tbody>


</table>


</div>


</div>



</div>



<?php

include "../includes/footer.php";

?>