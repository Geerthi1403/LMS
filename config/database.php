<?php
$host="HOST";
$user="USERNAME";
$password="PASSWORD";
$db="DATABASE";

$conn=mysqli_connect(
$host,
$user,
$password,
$db
);

if(!$conn){
die("Database Connection Failed");
}
?>
