<?php

include "../config/database.php";



// =============================
// Return Book
// =============================

if(isset($_GET['return'])){


    $issue_id = mysqli_real_escape_string(
        $conn,
        $_GET['return']
    );



    // Get issue details

    $issueQuery = mysqli_query(
        $conn,
        "
        SELECT

        student_id,
        book_id,
        expected_return_date

        FROM issue_books

        WHERE id='$issue_id'

        "
    );



    $issue = mysqli_fetch_assoc($issueQuery);



    if($issue){


        $student_id = $issue['student_id'];

        $book_id = $issue['book_id'];

        $expected_return_date = $issue['expected_return_date'];



        // Current return date

        $return_date = date("Y-m-d");



        // Calculate late days

        $late_days = 0;



        if(
            !empty($expected_return_date)
            &&
            $return_date > $expected_return_date
        ){


            $date1 = new DateTime(
                $expected_return_date
            );


            $date2 = new DateTime(
                $return_date
            );


            $difference = $date1->diff($date2);


            $late_days = $difference->days;


        }





        // Fine calculation

        $fine_per_day = 20;


        $fine_amount = $late_days * $fine_per_day;







        // Update Issue Book


        mysqli_query(
            $conn,
            "
            UPDATE issue_books

            SET

            status='returned',

            return_date=CURDATE()

            WHERE id='$issue_id'

            "
        );







        // Increase Available Book


        mysqli_query(
            $conn,
            "
            UPDATE books

            SET available = available + 1

            WHERE id='$book_id'

            "
        );







        // Insert Fine


        if($late_days > 0){



            // Check existing fine

            $checkFine = mysqli_query(
                $conn,
                "
                SELECT id

                FROM fines

                WHERE

                student_id='$student_id'

                AND

                book_id='$book_id'

                AND

                status='unpaid'

                "
            );




            if(mysqli_num_rows($checkFine)==0){



                mysqli_query(
                    $conn,
                    "
                    INSERT INTO fines

                    (
                        student_id,
                        book_id,
                        late_days,
                        amount,
                        status
                    )

                    VALUES

                    (
                        '$student_id',
                        '$book_id',
                        '$late_days',
                        '$fine_amount',
                        'unpaid'
                    )

                    "
                );


            }



        }



    }





    header("Location: issue-books.php");

    exit();


}






// =============================
// Get Issued Books
// =============================


$result = mysqli_query(

$conn,

"

SELECT


issue_books.id,

issue_books.issue_date,

issue_books.expected_return_date,

issue_books.return_date,

issue_books.status,



students.first_name,

students.last_name,

students.username,



books.book_name,

books.authors



FROM issue_books



JOIN students

ON issue_books.student_id = students.id



JOIN books

ON issue_books.book_id = books.id



ORDER BY issue_books.id DESC



"

);






include "../includes/admin-header.php";


?>





<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8">

Issue Books Management

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
Issue Date
</th>


<th class="p-3">
Expected Return
</th>


<th class="p-3">
Returned Date
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

<?= htmlspecialchars(
$row['username']
) ?>

</span>


</td>






<td class="p-3">


<b>

<?= htmlspecialchars(
$row['book_name']
) ?>

</b>


<br>


<span class="text-sm text-gray-500">

<?= htmlspecialchars(
$row['authors']
) ?>

</span>


</td>






<td class="p-3">

<?= htmlspecialchars(
$row['issue_date']
) ?>

</td>







<td class="p-3">

<?= 

$row['expected_return_date']

?

htmlspecialchars(
$row['expected_return_date']
)

:

"-"

?>

</td>







<td class="p-3">

<?=

$row['return_date']

?

htmlspecialchars(
$row['return_date']
)

:

"-"

?>

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


<?php if($row['status']=="issued"){ ?>


<a

href="issue-books.php?return=<?= $row['id'] ?>"

onclick="return confirm('Return this book?')"

class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"

>

Return

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

<td colspan="7"

class="text-center p-10 text-gray-500">

No Issued Books Found

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