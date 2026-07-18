<?php

include "../config/database.php";
include "../includes/student-header.php";


$student_id = $_SESSION['id'];



// Get Student Data

$query = mysqli_query(
    $conn,
    "
    SELECT * FROM students
    WHERE id='$student_id'
    "
);


$student = mysqli_fetch_assoc($query);




// Update Profile

if(isset($_POST['update'])){


    $first_name = mysqli_real_escape_string(
        $conn,
        $_POST['first_name']
    );


    $last_name = mysqli_real_escape_string(
        $conn,
        $_POST['last_name']
    );


    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );


    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );



    $image = $student['image'];



    // Image Upload

    if(isset($_FILES['image']) && $_FILES['image']['name']!=""){


        $fileName = time()."_".$_FILES['image']['name'];


        $target = "../uploads/".$fileName;



        $extension = strtolower(
            pathinfo($fileName,PATHINFO_EXTENSION)
        );


        $allowed = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];



        if(in_array($extension,$allowed)){


            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $target
            );


            $image = $fileName;


        }


    }




    mysqli_query(
        $conn,
        "
        UPDATE students SET

        first_name='$first_name',

        last_name='$last_name',

        email='$email',

        phone='$phone',

        image='$image'


        WHERE id='$student_id'

        "
    );



    $success = "Profile updated successfully";



    // Refresh data

    $query = mysqli_query(
        $conn,
        "
        SELECT * FROM students
        WHERE id='$student_id'
        "
    );


    $student = mysqli_fetch_assoc($query);



}



?>



<div class="max-w-3xl mx-auto py-10">



<div class="bg-white shadow rounded-2xl p-8">



<h1 class="text-3xl font-bold text-gray-800 text-center">

My Profile

</h1>




<?php if(isset($success)){ ?>


<div class="mt-5 bg-green-100 text-green-700 p-4 rounded-xl text-center">

<?= $success ?>

</div>


<?php } ?>






<form method="POST"
enctype="multipart/form-data"
class="mt-8 space-y-5">





<!-- Profile Image -->


<div class="text-center">


<?php if($student['image']!=""){ ?>


<img

src="../uploads/<?= htmlspecialchars($student['image']) ?>"

class="w-32 h-32 rounded-full object-cover mx-auto"

>


<?php }else{ ?>


<div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center mx-auto text-gray-500">

No Image

</div>


<?php } ?>


<input

type="file"

name="image"

class="mt-4 block mx-auto"

accept="image/*"

>


</div>






<div class="grid grid-cols-1 md:grid-cols-2 gap-5">



<div>

<label class="font-semibold">

First Name

</label>


<input

type="text"

name="first_name"

value="<?= htmlspecialchars($student['first_name']) ?>"

required

class="w-full mt-2 px-4 py-3 border rounded-xl"

>

</div>





<div>

<label class="font-semibold">

Last Name

</label>


<input

type="text"

name="last_name"

value="<?= htmlspecialchars($student['last_name']) ?>"

required

class="w-full mt-2 px-4 py-3 border rounded-xl"

>

</div>



</div>







<div>

<label class="font-semibold">

Username

</label>


<input

type="text"

value="<?= htmlspecialchars($student['username']) ?>"

readonly

class="w-full mt-2 px-4 py-3 border rounded-xl bg-gray-100"

>


</div>






<div>

<label class="font-semibold">

Register Number

</label>


<input

type="text"

value="<?= htmlspecialchars($student['roll_no']) ?>"

readonly

class="w-full mt-2 px-4 py-3 border rounded-xl bg-gray-100"

>


</div>







<div>

<label class="font-semibold">

Email

</label>


<input

type="email"

name="email"

value="<?= htmlspecialchars($student['email']) ?>"

class="w-full mt-2 px-4 py-3 border rounded-xl"

>


</div>






<div>

<label class="font-semibold">

Phone

</label>


<input

type="text"

name="phone"

value="<?= htmlspecialchars($student['phone']) ?>"

required

class="w-full mt-2 px-4 py-3 border rounded-xl"

>


</div>






<button

name="update"

class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">

Update Profile

</button>





</form>



</div>



</div>



<?php

include "../includes/footer.php";

?>