<?php

include "config/database.php";
include "includes/header.php";


$error = "";


if(isset($_POST['register'])){


    $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn,$_POST['last_name']);
    $username   = mysqli_real_escape_string($conn,$_POST['username']);
    $roll_no    = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $email      = mysqli_real_escape_string($conn,$_POST['email']);
    $phone      = mysqli_real_escape_string($conn,$_POST['phone']);

    $password   = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // Roll Number Validation
    if (!preg_match('/^JF\/[A-Z]+\/\d{2}\/\d{2}$/', $roll_no)) {
        $error = "Roll Number format must be JF/ICT/22/01";
    }


    // Password check

    if($password != $confirm_password){


        $error = "Passwords do not match";


    }

    else{


        // Username & Email Check

        $check = mysqli_query($conn,"
        
        SELECT * FROM students 
        
        WHERE username='$username'
        OR email='$email'

        ");



        if(mysqli_num_rows($check)>0){


            $error = "Username or Email already exists";


        }

        else{


            // Image Upload

            $image = "";


            if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){


                $imageName = time()."_".$_FILES['image']['name'];


                $target = "uploads/".$imageName;



                $allowed = [
                    "jpg",
                    "jpeg",
                    "png",
                    "webp"
                ];


                $extension = strtolower(
                    pathinfo($imageName,PATHINFO_EXTENSION)
                );



                if(in_array($extension,$allowed)){


                    move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        $target
                    );


                    $image = $imageName;


                }
                else{


                    $error = "Only JPG, PNG and WEBP images allowed";


                }


            }



            if($error==""){


                $hash_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );



                $insert = mysqli_query($conn,"

                INSERT INTO students

                (
                    first_name,
                    last_name,
                    username,
                    password,
                    roll_no,
                    email,
                    phone,
                    image
                )

                VALUES

                (
                    '$first_name',
                    '$last_name',
                    '$username',
                    '$hash_password',
                    '$roll_no',
                    '$email',
                    '$phone',
                    '$image'
                )

                ");



                if($insert){


                    echo "
                    
                    <script>
                    alert('Registration Successful');
                    window.location='login.php';
                    </script>

                    ";


                    exit();


                }
                else{


                    $error="Registration failed";


                }


            }



        }


    }



}


?>



<div class="flex-1 flex items-center justify-center px-4 py-6">


<div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-8">



<h1 class="text-3xl font-bold text-center">

Student Registration

</h1>


<p class="text-center text-gray-500 mt-2">

Create your library account

</p>



<?php if($error){ ?>


<div class="mt-5 bg-red-100 text-red-700 p-3 rounded-lg text-center">

<?= $error ?>

</div>


<?php } ?>




<form 
method="POST"
enctype="multipart/form-data"
class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">





<div>

<label class="font-semibold">
First Name *
</label>

<input
type="text"
name="first_name"
required
class="input"
placeholder="First Name">

</div>





<div>

<label class="font-semibold">
Last Name *
</label>

<input
type="text"
name="last_name"
required
class="input"
placeholder="Last Name">

</div>





<div>

<label class="font-semibold">
Username *
</label>

<input
type="text"
name="username"
required
class="input"
placeholder="Username">

</div>





<div>

<label class="font-semibold">
Register Number *
</label>

<div class="flex mt-2">
    

    <input
        type="text"
        name="roll_no"
        required
        placeholder="JF/ICT/22/01"
        class="w-full border rounded-r-xl px-4 py-3 focus:ring-2 focus:ring-blue-500"
    >

</div>

</div>




<div>

<label class="font-semibold">
Email *
</label>

<input
type="email"
name="email"
required
class="input"
placeholder="Email">

</div>





<div>

<label class="font-semibold">
Phone *
</label>

<input
type="text"
name="phone"
required
class="input"
placeholder="Phone">

</div>





<div>

<label class="font-semibold">
Password *
</label>

<input
type="password"
name="password"
required
class="input"
placeholder="Password">

</div>





<div>

<label class="font-semibold">
Confirm Password *
</label>

<input
type="password"
name="confirm_password"
required
class="input"
placeholder="Confirm Password">

</div>






<div class="md:col-span-2">


<label class="font-semibold">

Profile Image

</label>


<input
type="file"
name="image"
accept="image/*"
class="w-full mt-2 border rounded-xl p-3">


</div>





<div class="md:col-span-2">


<button
name="register"
class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">

Register

</button>


</div>




</form>



<div class="text-center mt-6">

Already have account?

<a href="login.php"
class="text-blue-600 font-semibold">

Login

</a>


</div>



</div>


</div>




<?php

include "includes/footer.php";

?>