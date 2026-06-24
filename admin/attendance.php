<?php
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";

if (isset($_POST['save'])) {
    $student_id = $_POST['student_id'];
    $attendance_date = $_POST['attendance_date'];
    $status = $_POST['status'];

    $insert = mysqli_query(
        $conn,
        "INSERT INTO attendance
        (student_id, attendance_date, status)
        VALUES
        (
        '$student_id',
        '$attendance_date',
        '$status'
        )"
    );

    if ($insert) {
        $message = "Attendance Saved Successfully";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <h2>Attendance Management</h2>

        <?php
        if ($message != "") {
        ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php
        }
        ?>

        <form method="post">

            <div class="mb-3">

                <label>Select Student</label>

                <select name="student_id" class="form-control" required>

                    <option value="">Select Student</option>

                    <?php

                    $students = mysqli_query(
                        $conn,
                        "SELECT * FROM users
     WHERE role='student'"
                    );

                    while ($student = mysqli_fetch_assoc($students)) {
                    ?>

                        <option value="<?php echo $student['id']; ?>">
                            <?php echo $student['name']; ?>
                        </option>

                    <?php
                    }
                    ?>

                </select>

            </div>

            <div class="mb-3">

                <label>Date</label>

                <input type="date"
                    name="attendance_date"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Status</label>

                <select name="status"
                    class="form-control"
                    required>

                    <option value="Present">Present</option>

                    <option value="Absent">Absent</option>

                </select>

            </div>

            <input type="submit"
                name="save"
                value="Save Attendance"
                class="btn btn-success">

            <a href="dashboard.php"
                class="btn btn-primary">
                Back
            </a>

        </form>

    </div>

</body>

</html>