<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}


if(!isset($_SESSION['username']) || $_SESSION['role'] != "student"){

    header("Location: ../login.php");
    exit();

}


include_once __DIR__ . "/../config/database.php";



$student_image = "";


if(isset($_SESSION['id'])){


    $student_id = $_SESSION['id'];


    $imageQuery = mysqli_query(
        $conn,
        "
        SELECT image 
        FROM students
        WHERE id='$student_id'
        "
    );


    if(mysqli_num_rows($imageQuery)>0){

        $studentData = mysqli_fetch_assoc($imageQuery);

        $student_image = $studentData['image'];

    }

}



?>


<!DOCTYPE html>

<html lang="en">


<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Student Dashboard - LMS
</title>


<script src="https://cdn.tailwindcss.com"></script>


<link rel="stylesheet" href="/LMS/assets/css/style.css">


</head>



<body class="bg-gray-100 min-h-screen flex flex-col">



<nav class="bg-gray-900 text-white shadow">


<div class="max-w-7xl mx-auto px-4">



<div class="flex justify-between items-center h-16">





<!-- Logo -->


<a href="/LMS/student/dashboard.php"
class="flex items-center gap-3">


<img

src="/LMS/assets/images/logo.png"

class="w-11 h-11 rounded-xl object-cover"

>


<span class="text-xl font-bold">

LMS

</span>


</a>







<!-- Desktop Menu -->


<div class="hidden md:flex items-center gap-6">



<a href="/LMS/student/dashboard.php"
class="hover:text-blue-400">

Dashboard

</a>



<a href="/LMS/student/books.php"
class="hover:text-blue-400">

Books

</a>



<a href="/LMS/student/issued-books.php"
class="hover:text-blue-400">

Issued Books

</a>



<a href="/LMS/student/fine.php"
class="hover:text-blue-400">

Fine

</a>



<!-- <a href="/LMS/student/profile.php"
class="hover:text-blue-400">

Profile

</a> -->






<!-- Desktop Profile Dropdown -->


<div class="relative">


<button

id="student-profile-btn"

class="flex items-center gap-2">


<?php if(!empty($student_image)){ ?>


<img

src="/LMS/uploads/<?= htmlspecialchars($student_image) ?>"

class="w-10 h-10 rounded-full object-cover"

>


<?php }else{ ?>


<div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">

👤

</div>


<?php } ?>



<span>

<?= htmlspecialchars($_SESSION['username']) ?>

</span>


<span>

▼

</span>


</button>






<div

id="student-profile-menu"

class="hidden absolute right-0 mt-3 w-44 bg-white text-gray-800 rounded-xl shadow-lg p-2 z-50">



<a

href="/LMS/student/profile.php"

class="block px-4 py-2 rounded-lg hover:bg-gray-100">

My Profile

</a>




<a

href="/LMS/logout.php"

class="block px-4 py-2 rounded-lg text-red-600 hover:bg-red-100">

Logout

</a>



</div>


</div>



</div>







<!-- Mobile Hamburger Only -->


<button

id="menu-btn"

class="md:hidden text-3xl">


☰


</button>



</div>







<!-- Mobile Menu -->


<div

id="mobile-menu"

class="hidden md:hidden bg-gray-800 rounded-xl p-4 mb-3">



<a href="/LMS/student/dashboard.php"

class="block py-3 hover:text-blue-400">

Dashboard

</a>



<a href="/LMS/student/books.php"

class="block py-3 hover:text-blue-400">

Books

</a>



<a href="/LMS/student/issued-books.php"

class="block py-3 hover:text-blue-400">

Issued Books

</a>



<a href="/LMS/student/fine.php"

class="block py-3 hover:text-blue-400">

Fine

</a>



<a href="/LMS/student/profile.php"

class="block py-3 hover:text-blue-400">

Profile

</a>



<a href="/LMS/logout.php"

class="block bg-red-500 text-center py-3 rounded-lg mt-3">

Logout

</a>



</div>




</div>


</nav>





<main class="sm:px-6 lg:px-8 py-6">





<script>


// Mobile Hamburger


const menuBtn = document.getElementById("menu-btn");

const mobileMenu = document.getElementById("mobile-menu");



menuBtn.addEventListener("click",function(e){


e.stopPropagation();


mobileMenu.classList.toggle("hidden");


if(mobileMenu.classList.contains("hidden")){


menuBtn.innerHTML="☰";


}else{


menuBtn.innerHTML="✕";


}


});








// Desktop Profile Dropdown


const profileBtn = document.getElementById("student-profile-btn");

const profileMenu = document.getElementById("student-profile-menu");



profileBtn.addEventListener("click",function(e){


e.stopPropagation();


profileMenu.classList.toggle("hidden");


});






// Outside Click


document.addEventListener("click",function(){


mobileMenu.classList.add("hidden");


menuBtn.innerHTML="☰";


profileMenu.classList.add("hidden");


});




mobileMenu.addEventListener("click",function(e){


e.stopPropagation();


});



profileMenu.addEventListener("click",function(e){


e.stopPropagation();


});





// Resize


window.addEventListener("resize",function(){


if(window.innerWidth >= 768){


mobileMenu.classList.add("hidden");


menuBtn.innerHTML="☰";


}


});



</script>