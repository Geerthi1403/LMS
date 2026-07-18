<?php

include "../config/database.php";
include "../includes/student-header.php";


// Search

$search = "";


if(isset($_GET['search'])){


    $search = mysqli_real_escape_string($conn,$_GET['search']);


    $sql = "
    SELECT * FROM books
    WHERE 
    book_name LIKE '%$search%'
    OR authors LIKE '%$search%'
    OR department LIKE '%$search%'
    ";

}
else{


    $sql = "SELECT * FROM books";


}



$result = mysqli_query($conn,$sql);



?>


<div class="py-8 px-2 sm:px-4">


<h1 class="text-3xl font-bold text-gray-800 text-center">

Available Books

</h1>


<p class="text-center text-gray-600 mt-3">

Search and request books from the library collection.

</p>




<!-- Search -->


<div class="max-w-3xl mx-auto mt-8">


<form method="GET"
class="flex flex-col sm:flex-row gap-3">


<input

type="text"

name="search"

value="<?= htmlspecialchars($search) ?>"

placeholder="Search book name, author or department..."

class="flex-1 px-5 py-3 rounded-xl border focus:outline-none focus:ring-2 focus:ring-blue-500"


>


<button

class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold">

Search

</button>


</form>


</div>





<!-- Books -->


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6 mt-10">



<?php if(mysqli_num_rows($result)>0): ?>


<?php while($row=mysqli_fetch_assoc($result)): ?>



<div class="bg-white shadow rounded-2xl p-6 hover:shadow-xl transition">



<h2 class="text-xl font-bold text-gray-800">

<?= htmlspecialchars($row['book_name']) ?>

</h2>




<div class="mt-5 space-y-2 text-gray-600">


<p>

📚 <b>Author:</b>

<?= htmlspecialchars($row['authors']) ?>

</p>


<p>

📖 <b>Edition:</b>

<?= htmlspecialchars($row['edition']) ?>

</p>


<p>

🏫 <b>Department:</b>

<?= htmlspecialchars($row['department']) ?>

</p>


<p>

📦 <b>Total:</b>

<?= htmlspecialchars($row['quantity']) ?>

</p>


<p>

✅ <b>Available:</b>

<?= htmlspecialchars($row['available']) ?>

</p>



</div>





<?php if($row['available'] > 0): ?>


<a

href="request-book.php?book_id=<?= $row['id'] ?>"

onclick="return confirm('Request this book?')"

class="block text-center mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">

Request Book

</a>



<?php else: ?>


<button

disabled

class="w-full mt-6 bg-gray-400 text-white py-3 rounded-xl font-semibold">

Not Available

</button>



<?php endif; ?>



</div>



<?php endwhile; ?>



<?php else: ?>


<div class="col-span-full bg-white rounded-xl shadow p-10 text-center">


<h2 class="text-2xl font-bold text-gray-700">

No Books Found

</h2>


<p class="text-gray-500 mt-3">

Try another search keyword.

</p>


</div>



<?php endif; ?>



</div>



</div>



<?php

include "../includes/footer.php";

?>