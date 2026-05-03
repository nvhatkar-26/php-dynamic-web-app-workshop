<?php include 'db.php'; ?>
<form method="POST">
    Name: <input type="text" name="name"><br>
    Email: <input type="text" name="email"><br>
    Course: <input type="text" name="course"><br>
    <button type="submit" name="submit">Add</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students (name, email, course)
            VALUES ('$name', '$email', '$course')";

    $conn->query($sql);

    echo "Student Added!";
}
?>
