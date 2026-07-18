<?php

include "config/database.php";
include "config/mail.php";


$message = "";
$error = "";


if(isset($_POST['submit'])){


    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );


    // Check student

    $studentQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM students
        WHERE email='$email'
        "
    );


    // Check admin

    $adminQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM admins
        WHERE email='$email'
        "
    );



    $user = null;
    $table = "";



    if(mysqli_num_rows($studentQuery)>0){

        $user = mysqli_fetch_assoc($studentQuery);

        $table="students";

    }
    elseif(mysqli_num_rows($adminQuery)>0){

        $user = mysqli_fetch_assoc($adminQuery);

        $table="admins";

    }



    if($user){


        // Generate Token

        $token = bin2hex(
            random_bytes(32)
        );


        // Expire after 1 hour

        $expiry = date(
            "Y-m-d H:i:s",
            strtotime("+1 hour")
        );



        mysqli_query(
            $conn,
            "
            UPDATE $table

            SET

            reset_token='$token',

            token_expiry='$expiry'

            WHERE id='{$user['id']}'

            "
        );



        $resetLink =
        "http://localhost:8080/LMS/reset-password.php?token=".$token;



        $name =
        $user['first_name']." ".$user['last_name'];



        if(
        sendResetMail(
            $user['email'],
            $name,
            $resetLink
        )
        ){

            $message =
            "Reset link sent to your email.";

        }
        else{

            $error =
            "Email sending failed.";

        }



    }
    else{

        $error =
        "Email not found.";

    }



}



include "includes/header.php";

?>



<div class="min-h-screen flex items-center justify-center">


<div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">



<h2 class="text-3xl font-bold text-center">

Forgot Password

</h2>


<p class="text-center text-gray-500 mt-2">

Enter your registered email

</p>




<?php if($message){ ?>

<div class="bg-green-100 text-green-700 p-3 rounded mt-5">

<?= $message ?>

</div>

<?php } ?>




<?php if($error){ ?>

<div class="bg-red-100 text-red-700 p-3 rounded mt-5">

<?= $error ?>

</div>

<?php } ?>





<form method="POST" class="mt-6">


<label class="font-semibold">

Email

</label>


<input

type="email"

name="email"

required

placeholder="Enter your email"

class="w-full border px-4 py-3 rounded-xl mt-2"

>



<button

name="submit"

class="w-full bg-blue-600 text-white py-3 rounded-xl mt-5 hover:bg-blue-700">

Send Reset Link

</button>



</form>




<div class="text-center mt-5">

<a href="login.php"
class="text-blue-600">

Back to Login

</a>

</div>



</div>


</div>



<?php

include "includes/footer.php";

?>