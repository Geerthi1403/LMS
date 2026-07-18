<?php

include "../config/database.php";


if(isset($_POST['add_book'])){


    $book_name = mysqli_real_escape_string($conn,$_POST['book_name']);

    $authors = mysqli_real_escape_string($conn,$_POST['authors']);

    $edition = mysqli_real_escape_string($conn,$_POST['edition']);

    $department = mysqli_real_escape_string($conn,$_POST['department']);

    $quantity = mysqli_real_escape_string($conn,$_POST['quantity']);


    // Available initially equals quantity

    $available = $quantity;



    $sql = "
    INSERT INTO books
    (
        book_name,
        authors,
        edition,
        department,
        quantity,
        available
    )
    VALUES
    (
        '$book_name',
        '$authors',
        '$edition',
        '$department',
        '$quantity',
        '$available'
    )
    ";



    if(mysqli_query($conn,$sql)){


        $_SESSION['success'] = "Book Added Successfully";


        header("Location: books.php");
        exit();


    }
    else{


        $error = "Failed to add book";

    }


}
include "../includes/admin-header.php";


?>



<div class="py-8 px-2 sm:px-4">


<div class="bg-white max-w-2xl mx-auto rounded-2xl shadow-xl p-8">



<h1 class="text-3xl font-bold text-gray-800 text-center">

Add New Book

</h1>



<?php if(isset($error)){ ?>

<div class="mt-5 bg-red-100 text-red-700 p-3 rounded-lg text-center">

<?= $error ?>

</div>

<?php } ?>





<form method="POST" class="mt-8 space-y-5">





<div>

<label class="block font-semibold text-gray-700 mb-2">

Book Name

</label>


<input

type="text"

name="book_name"

required

placeholder="Enter book name"

class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500"

>

</div>






<div>

<label class="block font-semibold text-gray-700 mb-2">

Author

</label>


<input

type="text"

name="authors"

required

placeholder="Enter author name"

class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500"

>

</div>






<div>

<label class="block font-semibold text-gray-700 mb-2">

Edition

</label>


<input

type="text"

name="edition"

placeholder="Enter edition"

class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500"

>

</div>






<div>

<label class="block font-semibold text-gray-700 mb-2">

Department

</label>

<select
    name="department"
    required
    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500"
>

    <option value="">-- Select Department --</option>

    <option value="HND in Building Services Technology">HND in Building Services Technology</option>

    <option value="HND in Cosmetology">HND in Cosmetology</option>

    <option value="HND in Farm Machinery Technology">HND in Farm Machinery Technology</option>

    <option value="HND in Food Technology">HND in Food Technology</option>

    <option value="HND in Construction Technology">HND in Construction Technology</option>

    <option value="HND in Hospitality Management">HND in Hospitality Management</option>

    <option value="HND in ICT">HND in ICT</option>

    <option value="HND in Mechatronics Technology">HND in Mechatronics Technology</option>

    <option value="HND in Production Technology">HND in Production Technology</option>

</select>

</div>






<div>

<label class="block font-semibold text-gray-700 mb-2">

Quantity

</label>


<input

type="number"

name="quantity"

required

min="1"

placeholder="Enter quantity"

class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500"

>

</div>






<button

type="submit"

name="add_book"

class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition"

>

Add Book

</button>




</form>



</div>


</div>




<?php

include "../includes/footer.php";

?>