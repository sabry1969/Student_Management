<?php
session_start();
require "connection.php";

if (!isset($_SESSION['user'])) {
    header("Location: Login.html");
    exit;
}

$username = $_SESSION['user'];

// info student
$stmt = $connection->prepare("SELECT * FROM register WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Student not found");
}

$student_id = $student['id'];

// courses + grades
$stmt_courses = $connection->prepare("SELECT course_name, mark, gpa FROM student_courses WHERE student_id = ?");
$stmt_courses->bind_param("s", $student_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

// Export to Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_info.xls");
header("Pragma: no-cache");
header("Expires: 0");

// info student
echo "Student Name:\t" . $student['name'] . "\n";
echo "Email:\t" . $student['email'] . "\n";
echo "Phone:\t" . $student['phone'] . "\n";
echo "Nationality:\t" . $student['nationality'] . "\n";
echo "Birthdate:\t" . $student['birthdate'] . "\n";
echo "\n"; 

// courses + grades
echo "Course\tMark\tGPA\n";
while($row = $result_courses->fetch_assoc()) {
    echo "{$row['course_name']}\t{$row['mark']}\t{$row['gpa']}\n";
}

exit;
