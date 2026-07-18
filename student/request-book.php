<?php

include "../config/database.php";
include "../includes/student-header.php";


$student_id = $_SESSION['id'];



// Check book id

if(!isset($_GET['book_id'])){

    header("Location: books.php");
    exit();

}


$book_id = $_GET['book_id'];




// Get Book Details

$bookQuery = mysqli_query(
    $conn,
    "
    SELECT * FROM books 
    WHERE id='$book_id'
    "
);


$book = mysqli_fetch_assoc($bookQuery);



if(!$book){

    echo "
    <div class='bg-red-100 text-red-700 p-4 rounded-xl'>
    Book not found
    </div>
    ";

    exit();

}





// Submit Request


if(isset($_POST['request'])){


    // Check available quantity

    if($book['available'] <= 0){


        $error = "Book is currently unavailable";


    }

    else{


        // Check duplicate request

        $check = mysqli_query(
            $conn,
            "
            SELECT * FROM book_requests

            WHERE student_id='$student_id'

            AND book_id='$book_id'

            AND status='pending'
            "
        );



        if(mysqli_num_rows($check)>0){


            $error = "You already requested this book";


        }

        else{


            // Check already issued

            $issued = mysqli_query(
                $conn,
                "
                SELECT * FROM issue_books

                WHERE student_id='$student_id'

                AND book_id='$book_id'

                AND status='issued'
                "
            );



            if(mysqli_num_rows($issued)>0){


                $error = "You already have this book";


            }

            else{


                mysqli_query(
                    $conn,
                    "
                    INSERT INTO book_requests
                    (
                        student_id,
                        book_id,
                        status
                    )

                    VALUES
                    (
                        '$student_id',
                        '$book_id',
                        'pending'
                    )
                    "
                );



                $success = "Book request submitted successfully";


            }


        }


    }


}


?>



<div class="max-w-xl mx-auto py-10">


<div class="bg-white shadow rounded-2xl p-8">



<h1 class="text-3xl font-bold text-gray-800 text-center">

Request Book

</h1>




<?php if(isset($error)){ ?>


<div class="mt-5 bg-red-100 text-red-700 p-4 rounded-xl text-center">

<?= $error ?>

</div>


<?php } ?>





<?php if(isset($success)){ ?>


<div class="mt-5 bg-green-100 text-green-700 p-4 rounded-xl text-center">


<?= $success ?>


</div>


<div class="text-center mt-5">

<a href="books.php"
class="text-blue-600 font-semibold">

Back to Books

</a>

</div>



<?php } else { ?>



<div class="mt-8 space-y-4">



<h2 class="text-xl font-bold">

<?= htmlspecialchars($book['book_name']) ?>

</h2>



<p>

📚 Author:

<?= htmlspecialchars($book['authors']) ?>

</p>



<p>

🏫 Department:

<?= htmlspecialchars($book['department']) ?>

</p>



<p>

📦 Available:

<?= htmlspecialchars($book['available']) ?>

</p>



<form method="POST">


<button

name="request"

class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">

Confirm Request

</button>


</form>



</div>




<?php } ?>



</div>


</div>



<?php

include "../includes/footer.php";

?>