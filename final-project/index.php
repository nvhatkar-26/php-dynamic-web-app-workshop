<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Students</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Students</h2>
<p><a href="add.php">Add Student</a></p>

<?php if (isset($_GET['added'])) { echo '<p class="notice">Student added.</p>'; } ?>
<?php if (isset($_GET['updated'])) { echo '<p class="notice">Student updated.</p>'; } ?>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['course'] . '</td>';
        echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a> | <a href="delete.php?id=' . $row['id'] . '" onclick="return confirm(\'Delete?\');">Delete</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">No students yet.</td></tr>';
}
?>
</table>

</body>
</html>
