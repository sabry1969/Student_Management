<?php
$connection = new mysqli('localhost', 'root', '', 'student_managment');
if (!$connection){
    die('Error' . mysqli_connect_error());
}
