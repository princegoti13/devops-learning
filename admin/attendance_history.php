<?php
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query(
    $conn,
    "SELECT
        attendance_date,
        subject,
        lecture_no,
        SUM(status='Present') AS total_present,
        SUM(status='Absent') AS total_absent
    FROM attendance
    GROUP BY
        attendance_date,
        subject,
        lecture_no
    ORDER BY attendance_date DESC, lecture_no ASC"
);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4">
            Attendance History
        </h2>

        <a href="attendance.php"
            class="btn btn-success mb-3">
            Add Attendance
        </a>

        <a href="dashboard.php"
            class="btn btn-primary mb-3">
            Back
        </a>

        <table class="table table-bordered table-striped">

            <?php

            $currentDate = "";

            while ($row = mysqli_fetch_assoc($result)) {

                if ($currentDate != $row['attendance_date']) {
                    $currentDate = $row['attendance_date'];
            ?>

                    <tr class="table-dark">

                        <td colspan="5">

                            <h5 class="mb-0">
                                📅 Date :
                                <?php echo $currentDate; ?>
                            </h5>

                        </td>

                    </tr>

                    <tr>

                        <th>Subject</th>
                        <th>Lecture</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Total</th>

                    </tr>

                <?php
                }
                ?>

                <tr>

                    <td>
                        <?php echo $row['subject']; ?>
                    </td>

                    <td>
                        Lecture <?php echo $row['lecture_no']; ?>
                    </td>

                    <td>
                        <span class="badge bg-success">
                            <?php echo $row['total_present']; ?>
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-danger">
                            <?php echo $row['total_absent']; ?>
                        </span>
                    </td>

                    <td>
                        <?php echo $row['total_present'] + $row['total_absent']; ?>
                    </td>

                </tr>

            <?php
            }
            ?>

        </table>

    </div>

</body>

</html>