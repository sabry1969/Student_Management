<?php
session_start();
require "connection.php"; 

if (!isset($_SESSION['user'])) {
    header("Location: Login.html");
    exit;
}

$username = $_SESSION['user'];

$stmt = $connection->prepare("SELECT * FROM register WHERE name = ?");
if (!$stmt) {
    die("Prepare failed for register: " . $connection->error);
}
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
if (!$stmt_courses) {
    die("Prepare failed for student_courses: " . $connection->error);
}
$stmt_courses->bind_param("s", $student_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student information</title>
    <link rel="stylesheet" href="info style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<header>
    <p>Student Information</p>
</header>

<div class="main">
    <div class="menu">
        <ul>
            <li class="profile">
                <div class="img-box">
                    <img src="student.png" alt="profile">
                </div>
                <h2><?= htmlspecialchars($student['name']) ?></h2>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-pen"></i>
                    <p>Courses</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-star"></i>
                    <p>Grades</p>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-book"></i>
                    <p>Service</p>
                </a>
            </li>

            <li class="log_out">
                <a href="logout.php">
                    <i class="fas fa-sign-out"></i>
                    <p>Log Out</p>
                </a>
            </li>
        </ul>
    </div>

    <div class="content">

        <div class="title">
            <p>Courses</p>
            <i class="fas fa-chart-bar"></i>
        </div>

        <div class="courses">
            <?php while($row = $result_courses->fetch_assoc()): ?>
                <div class="card"><?= htmlspecialchars($row['course_name']) ?></div>
            <?php endwhile; ?>
        </div>

        <div class="title">
            <p>Grades</p>
            <i class="fas fa-star"></i>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Mark</th>
                    <th>Gpa</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                $result_courses->data_seek(0);
                while($row = $result_courses->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['course_name']) ?></td>
                        <td><?= htmlspecialchars($row['mark']) ?></td>
                        <td><?= htmlspecialchars($row['gpa']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

            <div class="export">
                <div class="title">
                    <p>Service</p>
                    <i class="fa fa-cogs"></i>
                </div>
 
                <div class="export-buttons-container">
                    <form method="POST" action="export.php">
                        <button type="submit" name="export" class="export-btn">Export to Excel</button>
                    </form>

                <button type="button" class="export-btn" onclick="window.open('calculater/calf.html', '_blank')">
                    Calculator
                </button>
                </div>
            </div>
    </div>
</div>

</body>
</html>
