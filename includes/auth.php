<?php


session_start();



if(!isset($_SESSION['username'])){


header(
"location:/library-management-system/login.php"
);


exit();


}


?>