<?php

include "../config/database.php";



// Mark Fine Paid

if(isset($_GET['paid'])){


    $fine_id = $_GET['paid'];


    mysqli_query(
        $conn,
        "
        UPDATE fines

        SET status='paid'

        WHERE id='$fine_id'
        "
    );


    header("Location: fine.php");
    exit();

}





// Get Fines


$result = mysqli_query(

$conn,

"

SELECT


fines.id,

fines.late_days,

fines.amount,

fines.status,


students.first_name,

students.last_name,

students.username,


books.book_name


FROM fines



JOIN students

ON fines.student_id = students.id



JOIN books

ON fines.book_id = books.id



ORDER BY fines.id DESC


"

);


include "../includes/admin-header.php";

?>



<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8">

Fine Management

</h1>





<div class="bg-white shadow rounded-2xl p-6">



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
Late Days
</th>


<th class="p-3">
Amount
</th>


<th class="p-3">
Status
</th>


<th class="p-3">
Action
</th>


</tr>


</thead>




<tbody>



<?php if(mysqli_num_rows($result)>0){ ?>



<?php while($row=mysqli_fetch_assoc($result)){ ?>



<tr class="border-b hover:bg-gray-50">



<td class="p-3">


<?= htmlspecialchars(
$row['first_name']." ".$row['last_name']
) ?>


<br>


<span class="text-sm text-gray-500">

<?= htmlspecialchars($row['username']) ?>

</span>


</td>





<td class="p-3">

<?= htmlspecialchars($row['book_name']) ?>

</td>





<td class="p-3">

<?= htmlspecialchars($row['late_days']) ?>

Days

</td>





<td class="p-3 font-semibold">

Rs. <?= htmlspecialchars($row['amount']) ?>

</td>





<td class="p-3">



<?php if($row['status']=="paid"){ ?>


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Paid

</span>



<?php }else{ ?>


<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Unpaid

</span>



<?php } ?>


</td>





<td class="p-3">



<?php if($row['status']=="unpaid"){ ?>


<a

href="fine.php?paid=<?= $row['id'] ?>"

onclick="return confirm('Mark this fine as paid?')"

class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"

>

Mark Paid

</a>


<?php }else{ ?>


<span class="text-gray-500">

Completed

</span>


<?php } ?>


</td>



</tr>



<?php } ?>



<?php }else{ ?>


<tr>

<td colspan="6"

class="text-center p-10 text-gray-500">

No Fine Records Found

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