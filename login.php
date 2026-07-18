<?php

include "config/database.php";
include "includes/header.php";


if(isset($_POST['login'])){


    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];



    // Admin Login

    $adminQuery = "
        SELECT * FROM admins 
        WHERE username='$username'
    ";


    $adminResult = mysqli_query($conn,$adminQuery);



    if(mysqli_num_rows($adminResult) > 0){


        $admin = mysqli_fetch_assoc($adminResult);



        if(password_verify($password,$admin['password'])){


            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = "admin";
            $_SESSION['id'] = $admin['id'];


            header("Location: admin/dashboard.php");
            exit();

        }

    }




    // Student Login

    $studentQuery = "
        SELECT * FROM students
        WHERE username='$username'
    ";


    $studentResult = mysqli_query($conn,$studentQuery);



    if(mysqli_num_rows($studentResult) > 0){


        $student = mysqli_fetch_assoc($studentResult);



        if(password_verify($password,$student['password'])){


            $_SESSION['username'] = $student['username'];
            $_SESSION['role'] = "student";
            $_SESSION['id'] = $student['id'];


            header("Location: student/dashboard.php");
            exit();

        }

    }



    $error = "Invalid username or password";

}


?>



<div class="min-h-[calc(100vh-120px)] flex items-center justify-center px-4">


<div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-8">



<h2 class="text-3xl font-bold text-center text-gray-800">

Login

</h2>



<p class="text-center text-gray-500 mt-2">

Access your library account

</p>




<?php if(isset($error)){ ?>


<div class="mt-5 bg-red-100 text-red-700 p-3 rounded-lg text-center">

<?= $error ?>

</div>


<?php } ?>





<form method="POST" class="mt-8 space-y-5">





<!-- Username -->

<div>


<label class="block text-gray-700 font-semibold mb-2">

Username

</label>



<input
type="text"
name="username"
required
placeholder="Enter username"
class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
>


</div>





<!-- Password -->

<div>


<label class="block text-gray-700 font-semibold mb-2">

Password

</label>



<input
type="password"
name="password"
required
placeholder="Enter password"
class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
>


</div>






<button
type="submit"
name="login"
class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition">


Login


</button>




</form>



<div class="text-right mt-2">
    <a href="forgot-password.php"
       class="text-blue-600 hover:underline text-sm">
       Forgot Password?
    </a>
</div>


<div class="text-center mt-6 text-gray-600">


Don't have an account?


<a href="register.php"
class="text-blue-600 font-semibold hover:underline">

Register

</a>


</div>



</div>


</div>





<?php

include "includes/footer.php";

?>