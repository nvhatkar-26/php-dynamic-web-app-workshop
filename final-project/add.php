<?php
include 'db.php';

$error = '';
$name = '';
$email = '';
$course = '';

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    if ($name === '' || $email === '' || $course === '') {
        $error = 'Fill all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email.';
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $course);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?added=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Add Student</h2>
<p><a href="index.php">Back</a></p>

<?php if ($error != '') echo '<p class="error">' . $error . '</p>'; ?>

<form method="post">
    Name<br><input name="name" required value="<?php echo $name; ?>"><br>
    Email<br><input type="email" name="email" required value="<?php echo $email; ?>"><br>
    Course<br><input name="course" required value="<?php echo $course; ?>"><br>
    <button type="submit" name="submit">Add</button>
</form>

</body>
</html>
