<?php

include "../config/database.php";


if(!isset($_GET['id']) || empty($_GET['id'])){

    header("Location: students.php");
    exit();

}


$id = (int) $_GET['id'];


// Get student image before delete

$query = mysqli_query(
    $conn,
    "SELECT image FROM students WHERE id='$id'"
);


if(mysqli_num_rows($query)>0){

    $student = mysqli_fetch_assoc($query);


    // Delete image

    if(!empty($student['image'])){

        $imagePath = "../uploads/".$student['image'];


        if(file_exists($imagePath)){

            unlink($imagePath);

        }

    }


    // Delete student

    mysqli_query(
        $conn,
        "DELETE FROM students WHERE id='$id'"
    );

}


header("Location: students.php?deleted=1");
exit();

?>