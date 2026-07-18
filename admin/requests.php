<?php

include "../config/database.php";




// Approve Request

if(isset($_POST['approve'])){


    $request_id = mysqli_real_escape_string(
        $conn,
        $_POST['request_id']
    );


    $return_date = mysqli_real_escape_string(
        $conn,
        $_POST['return_date']
    );




    // Get request details

    $request = mysqli_query(
        $conn,
        "
        SELECT *
        FROM book_requests
        WHERE id='$request_id'
        "
    );


    $data = mysqli_fetch_assoc($request);



    if($data){


        $student_id = $data['student_id'];

        $book_id = $data['book_id'];




        // Check available book


        $bookCheck = mysqli_query(
            $conn,
            "
            SELECT available
            FROM books
            WHERE id='$book_id'
            "
        );


        $book = mysqli_fetch_assoc($bookCheck);




        if($book['available'] > 0){



            // Insert issue book


            mysqli_query(
                $conn,
                "
                INSERT INTO issue_books
                (
                    student_id,
                    book_id,
                    issue_date,
                    expected_return_date,
                    status
                )


                VALUES
                (
                    '$student_id',
                    '$book_id',
                    CURDATE(),
                    '$return_date',
                    'issued'
                )

                "
            );





            // Update request status


            mysqli_query(
                $conn,
                "
                UPDATE book_requests

                SET status='approved'

                WHERE id='$request_id'

                "
            );





            // Reduce available


            mysqli_query(
                $conn,
                "
                UPDATE books

                SET available = available - 1

                WHERE id='$book_id'

                "
            );



        }


    }




    header("Location: requests.php");

    exit();


}






// Reject Request


if(isset($_GET['reject'])){


    $request_id = mysqli_real_escape_string(
        $conn,
        $_GET['reject']
    );



    mysqli_query(
        $conn,
        "
        UPDATE book_requests

        SET status='rejected'

        WHERE id='$request_id'

        "
    );



    header("Location: requests.php");

    exit();


}






// Get Requests


$result = mysqli_query(

$conn,

"

SELECT


book_requests.id,

book_requests.status,


students.first_name,

students.last_name,

students.username,


books.book_name,

books.authors



FROM book_requests



JOIN students

ON book_requests.student_id = students.id



JOIN books

ON book_requests.book_id = books.id



ORDER BY book_requests.id DESC



"

);





include "../includes/admin-header.php";

?>





<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8">

Book Requests

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
Author
</th>


<th class="p-3">
Status
</th>


<th class="p-3">
Expected Return Date
</th>


</tr>


</thead>





<tbody>



<?php if(mysqli_num_rows($result)>0){ ?>



<?php while($row=mysqli_fetch_assoc($result)){ ?>



<tr class="border-b">






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

<?= htmlspecialchars($row['authors']) ?>

</td>







<td class="p-3">


<?php if($row['status']=="pending"){ ?>


<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Pending

</span>



<?php }elseif($row['status']=="approved"){ ?>


<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Approved

</span>



<?php }else{ ?>


<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Rejected

</span>



<?php } ?>


</td>








<td class="p-3">



<?php if($row['status']=="pending"){ ?>




<form method="POST">



<input type="hidden"
name="request_id"
value="<?= $row['id'] ?>">





<input

type="date"

name="return_date"
placeholder="Return Date"

required

min="<?= date('Y-m-d') ?>"

class="border rounded-lg px-1 py-1"

>




<button

name="approve"

class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg"

onclick="return confirm('Approve this request?')"

>

Approve

</button>



</form>







<a

href="requests.php?reject=<?= $row['id'] ?>"

onclick="return confirm('Reject this request?')"

class="inline-block mt-2 bg-red-500 hover:bg-red-600 text-white py-2 px-24  rounded-lg"

>

Reject

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

<td colspan="5"

class="text-center p-10 text-gray-500">

No Requests Found

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