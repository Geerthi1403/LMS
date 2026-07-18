<?php

include "../config/database.php";

// Delete Student

if(isset($_GET['delete'])){


    $id = mysqli_real_escape_string(
        $conn,
        $_GET['delete']
    );



    // Get image

    $imgQuery = mysqli_query(
        $conn,
        "
        SELECT image 
        FROM students 
        WHERE id='$id'
        "
    );


    $img = mysqli_fetch_assoc($imgQuery);



    if($img && $img['image']!=""){


        $file = "../uploads/".$img['image'];


        if(file_exists($file)){

            unlink($file);

        }

    }



    mysqli_query(
        $conn,
        "
        DELETE FROM students 
        WHERE id='$id'
        "
    );



    header("Location: students.php");

    exit();

}

include "../includes/admin-header.php";


// Search

$search="";



if(isset($_GET['search'])){


    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );


    $query = "

    SELECT *

    FROM students

    WHERE

    first_name LIKE '%$search%'

    OR last_name LIKE '%$search%'

    OR username LIKE '%$search%'

    OR roll_no LIKE '%$search%'

    OR email LIKE '%$search%'

    ORDER BY id DESC

    ";


}
else{


    $query = "

    SELECT *

    FROM students

    ORDER BY id DESC

    ";


}




$result = mysqli_query(
    $conn,
    $query
);



?>



<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8">

Student Management

</h1>





<!-- Search -->

<div class="bg-white shadow rounded-2xl p-5 mb-8">



<form method="GET"

class="flex flex-col md:flex-row gap-3">



<input

type="text"

name="search"

value="<?= htmlspecialchars($search) ?>"

placeholder="Search name, username, register number or email..."

class="flex-1 px-5 py-3 border rounded-xl outline-none focus:ring-2 focus:ring-blue-500"

>



<button

class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold"

>

Search

</button>




<?php if($search!=""){ ?>


<a

href="students.php"

class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-xl text-center"

>

Clear

</a>



<?php } ?>



</form>



</div>









<!-- Desktop Table -->


<div class="hidden md:block bg-white shadow rounded-2xl p-6">


<div class="overflow-x-auto">



<table class="min-w-full text-left">



<thead class="bg-gray-100">


<tr>


<th class="p-3">
Image
</th>


<th class="p-3">
Name
</th>


<th class="p-3">
Username
</th>


<th class="p-3">
Register No
</th>


<th class="p-3">
Email
</th>


<th class="p-3">
Phone
</th>


<th class="p-3">
Action
</th>


</tr>


</thead>





<tbody>



<?php if(mysqli_num_rows($result)>0){ ?>



<?php while($student=mysqli_fetch_assoc($result)){ ?>



<tr class="border-b hover:bg-gray-50">





<td class="p-3">



<?php if($student['image']!=""){ ?>


<img

src="../uploads/<?= htmlspecialchars($student['image']) ?>"

class="w-12 h-12 rounded-full object-cover"

>



<?php }else{ ?>


<div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">

👤

</div>


<?php } ?>


</td>







<td class="p-3 font-semibold">

<?= htmlspecialchars(
$student['first_name']." ".$student['last_name']
) ?>


</td>






<td class="p-3">

<?= htmlspecialchars($student['username']) ?>

</td>






<td class="p-3">

<?= htmlspecialchars($student['roll_no']) ?>

</td>






<td class="p-3">

<?= htmlspecialchars($student['email']) ?>

</td>






<td class="p-3">

<?= htmlspecialchars($student['phone']) ?>

</td>






<td class="p-3">


<a

href="students.php?delete=<?= $student['id'] ?>"

onclick="return confirm('Delete this student?')"

class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg"

>

Delete

</a>


</td>




</tr>




<?php } ?>



<?php }else{ ?>



<tr>

<td colspan="7"

class="text-center p-10 text-gray-500">

No Students Found

</td>

</tr>


<?php } ?>



</tbody>



</table>



</div>



</div>











<!-- Mobile Card View -->


<div class="md:hidden space-y-4">



<?php


mysqli_data_seek($result,0);


if(mysqli_num_rows($result)>0){



while($student=mysqli_fetch_assoc($result)){



?>



<div class="bg-white shadow rounded-2xl p-5">



<div class="flex items-center gap-4">



<?php if($student['image']!=""){ ?>


<img

src="../uploads/<?= htmlspecialchars($student['image']) ?>"

class="w-16 h-16 rounded-full object-cover"

>


<?php }else{ ?>


<div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center text-xl">

👤

</div>


<?php } ?>




<div>


<h2 class="font-bold text-lg">

<?= htmlspecialchars(
$student['first_name']." ".$student['last_name']
) ?>

</h2>



<p class="text-gray-500">

@<?= htmlspecialchars($student['username']) ?>

</p>


</div>


</div>





<div class="mt-5 space-y-2 text-gray-600">


<p>

<b>Roll No:</b>

<?= htmlspecialchars($student['roll_no']) ?>

</p>



<p>

<b>Email:</b>

<?= htmlspecialchars($student['email']) ?>

</p>



<p>

<b>Phone:</b>

<?= htmlspecialchars($student['phone']) ?>

</p>



</div>





<a

href="students.php?delete=<?= $student['id'] ?>"

onclick="return confirm('Delete this student?')"

class="block text-center bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl mt-5"

>

Delete

</a>




</div>




<?php


}


}else{


?>


<div class="bg-white rounded-xl p-8 text-center text-gray-500">

No Students Found

</div>


<?php } ?>



</div>





</div>





<?php

include "../includes/footer.php";

?>