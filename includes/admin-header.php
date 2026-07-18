<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}


if(!isset($_SESSION['username']) || $_SESSION['role'] != "admin"){

    header("Location: ../login.php");
    exit();

}


include_once __DIR__ . "/../config/database.php";


$admin_image = "";


if(isset($_SESSION['id'])){


    $admin_id = $_SESSION['id'];


    $imageQuery = mysqli_query(
        $conn,
        "
        SELECT image 
        FROM admins
        WHERE id='$admin_id'
        "
    );


    if(mysqli_num_rows($imageQuery)>0){

        $adminData = mysqli_fetch_assoc($imageQuery);

        $admin_image = $adminData['image'];

    }

}


?>


<!DOCTYPE html>

<html lang="en">


<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Admin Dashboard - LMS
</title>


<script src="https://cdn.tailwindcss.com"></script>


<link rel="stylesheet" href="/LMS/assets/css/style.css">


</head>



<body class="bg-gray-100 min-h-screen flex flex-col">



<nav class="bg-gray-900 text-white shadow">



<div class="max-w-7xl mx-auto px-4">



<div class="flex justify-between items-center h-16">





<!-- Logo -->


<a href="/LMS/admin/dashboard.php"

class="flex items-center gap-3">


<img

src="/LMS/assets/images/logo.png"

class="w-11 h-11 rounded-xl object-cover"

>


<span class="text-xl font-bold">

Admin LMS

</span>


</a>







<!-- Desktop Menu -->


<div class="hidden md:flex items-center gap-5">



<a href="/LMS/admin/dashboard.php"
class="hover:text-blue-400">

Dashboard

</a>



<a href="/LMS/admin/students.php"
class="hover:text-blue-400">

Students

</a>



<a href="/LMS/admin/books.php"
class="hover:text-blue-400">

Books

</a>



<a href="/LMS/admin/requests.php"
class="hover:text-blue-400">

Requests

</a>



<a href="/LMS/admin/issue-books.php"
class="hover:text-blue-400">

Issue Books

</a>



<a href="/LMS/admin/fine.php"
class="hover:text-blue-400">

Fine

</a>







<!-- Admin Profile -->


<div class="relative">


<button

id="admin-profile-btn"

class="flex items-center gap-2">



<?php if(!empty($admin_image)){ ?>


<img

src="/LMS/uploads/<?= htmlspecialchars($admin_image) ?>"

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

id="admin-profile-menu"

class="hidden absolute right-0 mt-3 w-44 bg-white text-gray-800 rounded-xl shadow-lg p-2 z-50">



<a

href="/LMS/admin/profile.php"

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







<!-- Mobile Button -->


<button

id="admin-menu-btn"

class="md:hidden text-3xl">


☰


</button>





</div>








<!-- Mobile Menu -->


<div

id="admin-mobile-menu"

class="hidden md:hidden bg-gray-800 rounded-xl p-4 mb-3">



<a href="/LMS/admin/dashboard.php"

class="block py-3 hover:text-blue-400">

Dashboard

</a>




<a href="/LMS/admin/students.php"

class="block py-3 hover:text-blue-400">

Students

</a>




<a href="/LMS/admin/books.php"

class="block py-3 hover:text-blue-400">

Books

</a>




<a href="/LMS/admin/requests.php"

class="block py-3 hover:text-blue-400">

Requests

</a>




<a href="/LMS/admin/issue-books.php"

class="block py-3 hover:text-blue-400">

Issue Books

</a>




<a href="/LMS/admin/fine.php"

class="block py-3 hover:text-blue-400">

Fine

</a>




<a href="/LMS/admin/profile.php"

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


// Mobile Menu


const adminBtn = document.getElementById("admin-menu-btn");

const adminMenu = document.getElementById("admin-mobile-menu");



adminBtn.addEventListener("click",function(e){


e.stopPropagation();


adminMenu.classList.toggle("hidden");



if(adminMenu.classList.contains("hidden")){


adminBtn.innerHTML="☰";


}else{


adminBtn.innerHTML="✕";


}


});








// Profile Dropdown


const adminProfileBtn = document.getElementById("admin-profile-btn");

const adminProfileMenu = document.getElementById("admin-profile-menu");



adminProfileBtn.addEventListener("click",function(e){


e.stopPropagation();


adminProfileMenu.classList.toggle("hidden");


});







// Outside Click


document.addEventListener("click",function(){


adminMenu.classList.add("hidden");


adminBtn.innerHTML="☰";


adminProfileMenu.classList.add("hidden");


});





adminMenu.addEventListener("click",function(e){


e.stopPropagation();


});



adminProfileMenu.addEventListener("click",function(e){


e.stopPropagation();


});







// Resize


window.addEventListener("resize",function(){


if(window.innerWidth >= 768){


adminMenu.classList.add("hidden");


adminBtn.innerHTML="☰";


}


});



</script>