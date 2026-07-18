<?php

include "config/database.php";


$first_name = "Admin";
$last_name  = "User";
$username   = "admin";
$password   = "admin123";
$email      = "admin@gmail.com";
$phone      = "0771234567";
$image      = "default.png";


// Password Hash

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);



$sql = "
INSERT INTO admins
(
first_name,
last_name,
username,
password,
email,
phone,
image
)
VALUES
(
'$first_name',
'$last_name',
'$username',
'$hashedPassword',
'$email',
'$phone',
'$image'
)
";



if(mysqli_query($conn,$sql)){


    echo "Admin Created Successfully";

}
else{


    echo "Error : ".mysqli_error($conn);

}


?>

geer
123456789