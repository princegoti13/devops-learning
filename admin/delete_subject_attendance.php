<?php
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['date']) && isset($_GET['subject'])) {

    $date = mysqli_real_escape_string($conn, $_GET['date']);
    $subject = mysqli_real_escape_string($conn, $_GET['subject']);

    $sql = "DELETE FROM attendance
            WHERE attendance_date='$date'
            AND subject='$subject'";

    if (mysqli_query($conn, $sql)) {

        echo "
        <script>
            alert(
            '✅ Attendance Deleted Successfully.\n\n' +
            'Date : $date\n' +
            'Subject : $subject'
            );
            window.location='attendance_history.php';
        </script>
        ";
    } else {

        echo "
        <script>
            alert('Something Went Wrong');
            window.location='attendance_history.php';
        </script>
        ";
    }
} else {

    header("Location: attendance_history.php");
    exit();
}
