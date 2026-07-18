<?php

include "../config/database.php";

include "../includes/student-header.php";



$student_id = $_SESSION['id'];



// Get Issued Books


$result = mysqli_query(

$conn,

"

SELECT

issue_books.issue_date,

issue_books.expected_return_date,

issue_books.return_date,

issue_books.status,


books.book_name,

books.authors,

books.edition


FROM issue_books



JOIN books

ON issue_books.book_id = books.id



WHERE issue_books.student_id='$student_id'



ORDER BY issue_books.id DESC


"

);



?>




<div class="py-8 px-2 sm:px-4">


<h1 class="text-3xl font-bold text-gray-800 mb-8">

My Issued Books

</h1>






<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">





<?php if(mysqli_num_rows($result)>0){ ?>




<?php while($row=mysqli_fetch_assoc($result)){ ?>



<div class="bg-white shadow rounded-2xl p-6">





<h2 class="text-xl font-bold text-gray-800">

<?= htmlspecialchars($row['book_name']) ?>

</h2>




<p class="text-gray-600 mt-2">

📚 Author:

<?= htmlspecialchars($row['authors']) ?>

</p>




<p class="text-gray-600">

📖 Edition:

<?= htmlspecialchars($row['edition']) ?>

</p>






<hr class="my-4">






<p class="text-gray-600">

📅 Issue Date:

<b>

<?= htmlspecialchars($row['issue_date']) ?>

</b>

</p>







<p class="text-blue-600 font-semibold mt-2">

⏳ Return Before:

<?= htmlspecialchars($row['expected_return_date']) ?>

</p>






<?php if($row['return_date']){ ?>



<p class="text-green-600 mt-2">

✅ Returned Date:

<?= htmlspecialchars($row['return_date']) ?>

</p>



<?php } ?>







<div class="mt-4">


<?php if($row['status']=="issued"){ ?>


<span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full">

Issued

</span>



<?php }else{ ?>



<span class="bg-green-100 text-green-700 px-4 py-2 rounded-full">

Returned

</span>



<?php } ?>


</div>






</div>




<?php } ?>




<?php }else{ ?>




<div class="bg-white shadow rounded-xl p-10 text-center col-span-3">


<h2 class="text-xl font-bold text-gray-600">

No Issued Books Found

</h2>


</div>




<?php } ?>





</div>




</div>




<?php

include "../includes/footer.php";

?>