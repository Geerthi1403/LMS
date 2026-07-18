<?php

include "config/database.php";
include "includes/header.php";


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


<section class="py-10">


<div class="text-center mb-10">

<h1 class="text-4xl font-bold text-gray-800">

Library Books

</h1>


<p class="text-gray-600 mt-3">

Search and explore available books from our library collection.

</p>


</div>




<!-- Search Box -->

<div class="max-w-3xl mx-auto mb-10">


<form method="GET"
class="flex flex-col sm:flex-row gap-3">


<input

type="text"

name="search"

value="<?= htmlspecialchars($search) ?>"

placeholder="Search book name, author or department..."

class="flex-1 px-5 py-3 rounded-xl border outline-none focus:ring-2 focus:ring-blue-500"


>


<button

class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold"

>

Search

</button>


</form>


</div>





<?php if(mysqli_num_rows($result)>0): ?>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6">



<?php while($row=mysqli_fetch_assoc($result)): ?>


<div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-6">


<h2 class="text-xl font-bold text-gray-800">

<?= htmlspecialchars($row['book_name']) ?>

</h2>



<div class="mt-5 space-y-3 text-gray-600">


<p>

📚 
<b>Author:</b>

<?= htmlspecialchars($row['authors']) ?>

</p>



<p>

📖
<b>Edition:</b>

<?= htmlspecialchars($row['edition']) ?>

</p>



<p>

🏫
<b>Department:</b>

<?= htmlspecialchars($row['department']) ?>

</p>



<p>

📦
<b>Total Quantity:</b>

<?= htmlspecialchars($row['quantity']) ?>

</p>



<p>

✅
<b>Available:</b>

<?= htmlspecialchars($row['available']) ?>

</p>



<p>

🆔
<b>Book ID:</b>

<?= htmlspecialchars($row['id']) ?>

</p>



</div>




<?php if(
isset($_SESSION['username']) 
&& 
$_SESSION['role']=="student"
&& 
$row['available'] > 0
): ?>

<a

href="student/request-book.php?book_id=<?= $row['id'] ?>"

class="block text-center mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold"

>

Request Book

</a>



<?php elseif(!isset($_SESSION['username'])): ?>


<a

href="login.php"

class="block text-center mt-6 bg-gray-800 hover:bg-gray-900 text-white py-3 rounded-xl font-semibold"

>

Login to Request

</a>


<?php endif; ?>



</div>



<?php endwhile; ?>


</div>



<?php else: ?>


<div class="bg-white shadow rounded-xl p-10 text-center">


<h2 class="text-2xl font-bold text-gray-700">

No Books Found

</h2>


<p class="text-gray-500 mt-3">

Try another search keyword.

</p>


</div>


<?php endif; ?>


</section>



<?php

include "includes/footer.php";

?>