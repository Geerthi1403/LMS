<?php

include "config/database.php";


$message = "";
$error = "";

$token = "";



if(isset($_GET['token'])){

    $token = mysqli_real_escape_string(
        $conn,
        $_GET['token']
    );

}
else{

    $error = "Invalid reset link.";

}





$user = null;
$table = "";




// Check student token


if($token){


    $studentQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM students
        WHERE reset_token='$token'
        "
    );



    if(mysqli_num_rows($studentQuery)>0){


        $user = mysqli_fetch_assoc(
            $studentQuery
        );


        $table = "students";


    }






    // Check admin token


    if(!$user){


        $adminQuery = mysqli_query(
            $conn,
            "
            SELECT *
            FROM admins
            WHERE reset_token='$token'
            "
        );



        if(mysqli_num_rows($adminQuery)>0){


            $user = mysqli_fetch_assoc(
                $adminQuery
            );


            $table="admins";


        }


    }



}







// Check token expiry


if($user){


    if(
        strtotime($user['token_expiry'])
        <
        time()
    ){


        $error =
        "Reset link expired. Please request again.";


        $user = null;


    }


}









// Password Reset


if(isset($_POST['reset']) && $user){



    $password =
    $_POST['password'];



    $confirm =
    $_POST['confirm_password'];





    if($password != $confirm){


        $error =
        "Passwords do not match.";


    }

    elseif(strlen($password)<6){


        $error =
        "Password must be minimum 6 characters.";


    }

    else{



        $hashPassword =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );





        mysqli_query(
            $conn,
            "
            UPDATE $table

            SET

            password='$hashPassword',

            reset_token=NULL,

            token_expiry=NULL

            WHERE id='{$user['id']}'

            "
        );




        $message =
        "Password reset successful. Redirecting to login...";



        header(
            "refresh:3;url=login.php"
        );



    }


}





include "includes/header.php";


?>





<div class="min-h-screen flex items-center justify-center">



<div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">





<h2 class="text-3xl font-bold text-center">

Reset Password

</h2>




<?php if($error){ ?>


<div class="bg-red-100 text-red-700 p-3 rounded-lg mt-5">

<?= htmlspecialchars($error) ?>

</div>


<?php } ?>






<?php if($message){ ?>


<div class="bg-green-100 text-green-700 p-3 rounded-lg mt-5">

<?= htmlspecialchars($message) ?>

</div>


<?php } ?>






<?php if($user){ ?>





<form method="POST" class="mt-6">





<label class="font-semibold">

New Password

</label>



<input

type="password"

name="password"

required

class="w-full border px-4 py-3 rounded-xl mt-2"

placeholder="Enter new password"

>








<label class="font-semibold mt-5 block">

Confirm Password

</label>



<input

type="password"

name="confirm_password"

required

class="w-full border px-4 py-3 rounded-xl mt-2"

placeholder="Confirm password"

>







<button

name="reset"

class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl mt-6 font-semibold">

Reset Password

</button>






</form>





<?php } ?>






<div class="text-center mt-5">


<a href="login.php"

class="text-blue-600 hover:underline">

Back to Login

</a>


</div>




</div>



</div>






<?php

include "includes/footer.php";

?>