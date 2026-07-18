<?php

include "../config/database.php";
include "../includes/admin-header.php";


// Check admin login

if(!isset($_SESSION['id']) || $_SESSION['role']!="admin"){

    header("Location: ../login.php");
    exit();

}


$admin_id = $_SESSION['id'];



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



    // Current image

    $imageQuery = mysqli_query(
        $conn,
        "SELECT image FROM admins WHERE id='$admin_id'"
    );


    $oldImage = mysqli_fetch_assoc($imageQuery)['image'];



    $imageName = $oldImage;



    // Image Upload

    if(isset($_FILES['image']) && $_FILES['image']['name']!=""){


        $imageName = time()."_".$_FILES['image']['name'];


        $tmp = $_FILES['image']['tmp_name'];


        move_uploaded_file(
            $tmp,
            "../uploads/".$imageName
        );



        // Delete old image

        if($oldImage!=""){

            if(file_exists("../uploads/".$oldImage)){

                unlink("../uploads/".$oldImage);

            }

        }


    }





    mysqli_query(
        $conn,
        "

        UPDATE admins

        SET

        first_name='$first_name',

        last_name='$last_name',

        email='$email',

        phone='$phone',

        image='$imageName'


        WHERE id='$admin_id'

        "
    );



    $success = "Profile Updated Successfully";


}



// Get Admin Data


$result = mysqli_query(
    $conn,
    "SELECT * FROM admins WHERE id='$admin_id'"
);


$admin = mysqli_fetch_assoc($result);



?>



<div class="py-8 px-2 sm:px-4">



<h1 class="text-3xl font-bold text-gray-800 mb-8 center text-center">

Admin Profile

</h1>




<div class="bg-white shadow rounded-2xl p-8 max-w-3xl center mx-auto">



<?php if(isset($success)){ ?>


<div class="bg-green-100 text-green-700 p-3 rounded-lg mb-5">

<?= $success ?>

</div>


<?php } ?>




<form method="POST" enctype="multipart/form-data" class="space-y-5">





<div class="text-center">


<?php if($admin['image']!=""){ ?>


<img

src="../uploads/<?= htmlspecialchars($admin['image']) ?>"

class="w-28 h-28 rounded-full object-cover mx-auto"


>


<?php }else{ ?>


<div class="w-28 h-28 bg-gray-300 rounded-full mx-auto flex items-center justify-center text-4xl">

👤

</div>


<?php } ?>


</div>





<div>


<label class="font-semibold">

Profile Image

</label>


<input

type="file"

name="image"

accept="image/*"

class="w-full mt-2 border rounded-lg p-3"

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

value="<?= htmlspecialchars($admin['first_name']) ?>"

class="w-full mt-2 border rounded-lg p-3"

required

>


</div>





<div>

<label class="font-semibold">

Last Name

</label>


<input

type="text"

name="last_name"

value="<?= htmlspecialchars($admin['last_name']) ?>"

class="w-full mt-2 border rounded-lg p-3"

required

>


</div>



</div>





<div>


<label class="font-semibold">

Username

</label>


<input

type="text"

value="<?= htmlspecialchars($admin['username']) ?>"

class="w-full mt-2 border rounded-lg p-3 bg-gray-100"

readonly


>


</div>





<div>


<label class="font-semibold">

Email

</label>


<input

type="email"

name="email"

value="<?= htmlspecialchars($admin['email']) ?>"

class="w-full mt-2 border rounded-lg p-3"


>


</div>





<div>


<label class="font-semibold">

Phone

</label>


<input

type="text"

name="phone"

value="<?= htmlspecialchars($admin['phone']) ?>"

class="w-full mt-2 border rounded-lg p-3"


>


</div>






<button

name="update"

class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold"

>

Update Profile

</button>




</form>



</div>



</div>



<?php

include "../includes/footer.php";

?>