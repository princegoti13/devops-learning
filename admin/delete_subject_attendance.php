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
?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Delete Attendance</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>

        <body>

            <div class="container mt-5">

                <div class="alert alert-success text-center">

                    <h4>✅ Subject Attendance Deleted Successfully</h4>

                    <p>
                        Date :
                        <b><?php echo $date; ?></b>
                    </p>

                    <p>
                        Subject :
                        <b><?php echo $subject; ?></b>
                    </p>

                    <p>Redirecting To Attendance History...</p>

                </div>

            </div>

            <script>
                setTimeout(function() {
                    window.location = "attendance_history.php";
                }, 1500);
            </script>

        </body>

        </html>

<?php
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
?>