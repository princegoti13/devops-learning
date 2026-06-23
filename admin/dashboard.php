<?php
session_start();
include '../db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

$totalStudents = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM users WHERE role='student'"
    )
);

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );

    $result = mysqli_query(
        $conn,
        "SELECT * FROM users
         WHERE role='student'
         AND (
            name LIKE '%$search%'
            OR email LIKE '%$search%'
         )"
    );
}
else
{
    $result = mysqli_query(
        $conn,
        "SELECT * FROM users
         WHERE role='student'"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h1 class="mb-3">
Admin Dashboard
</h1>

<p>
Welcome,
<b><?php echo $_SESSION['name']; ?></b>
</p>

<a href="../logout.php"
   class="btn btn-danger mb-3">
Logout
</a>

<div class="card p-3 mb-4">

<h4>Total Students</h4>

<h2>
<?php echo $totalStudents; ?>
</h2>

</div>

<h3>Student Management</h3>

<form method="GET" class="mb-3">

<input type="text"
       name="search"
       class="form-control"
       placeholder="Search By Name Or Email"
       value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

</form>

<table class="table table-bordered table-striped">

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Course</th>
<th>Semester</th>
<th>Action</th>

</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['mobile']; ?></td>

<td><?php echo $row['course']; ?></td>

<td><?php echo $row['semester']; ?></td>

<td>

<a href="edit_student.php?id=<?php echo $row['id']; ?>"
   class="btn btn-warning btn-sm">
Edit
</a>

<a href="delete_student.php?id=<?php echo $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete Student?')">
Delete
</a>

</td>

</tr>

<?php
}
?>

</table>

</div>

</body>
</html>