<?php
session_start();
include '../db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

$message = "";

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];

    $sql = "UPDATE users SET
            name='$name',
            email='$email',
            mobile='$mobile',
            course='$course',
            semester='$semester'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql))
    {
        $message = "Student Updated Successfully";
    }
    else
    {
        $message = "Error : ".mysqli_error($conn);
    }
}

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$id'"
);

$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h2>Edit Student</h2>

<?php
if($message != "")
{
    echo "<div class='alert alert-success'>$message</div>";
}
?>

<form method="post">

<div class="mb-3">
<label>Name</label>

<input type="text"
       name="name"
       class="form-control"
       value="<?php echo $row['name']; ?>"
       required>
</div>

<div class="mb-3">
<label>Email</label>

<input type="email"
       name="email"
       class="form-control"
       value="<?php echo $row['email']; ?>"
       required>
</div>

<div class="mb-3">
<label>Mobile</label>

<input type="text"
       name="mobile"
       class="form-control"
       value="<?php echo $row['mobile']; ?>">
</div>

<div class="mb-3">
<label>Course</label>

<input type="text"
       name="course"
       class="form-control"
       value="<?php echo $row['course']; ?>">
</div>

<div class="mb-3">
<label>Semester</label>

<input type="text"
       name="semester"
       class="form-control"
       value="<?php echo $row['semester']; ?>">
</div>

<input type="submit"
       name="update"
       value="Update Student"
       class="btn btn-success">

<a href="dashboard.php"
   class="btn btn-primary">
Back
</a>

</form>

</div>

</body>
</html>