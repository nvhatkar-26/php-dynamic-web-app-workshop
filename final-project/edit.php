<?php
include 'db.php';

$error = '';

if (isset($_POST['submit'])) {
    $id = (int) $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    if ($id < 1) {
        header("Location: index.php");
        exit;
    }
    if ($name === '' || $email === '' || $course === '') {
        $error = 'Fill all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email.';
    } else {
        $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $course, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?updated=1");
        exit;
    }
} else {
    $id = (int) ($_GET['id'] ?? 0);
    if ($id < 1) {
        header("Location: index.php");
        exit;
    }
    $result = $conn->query("SELECT name, email, course FROM students WHERE id=$id");
    $row = $result ? $result->fetch_assoc() : null;
    if (!$row) {
        header("Location: index.php");
        exit;
    }
    $name = $row['name'];
    $email = $row['email'];
    $course = $row['course'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Student</h2>
<p><a href="index.php">Back</a></p>

<?php if ($error != '') echo '<p class="error">' . $error . '</p>'; ?>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Name<br><input name="name" required value="<?php echo $name; ?>"><br>
    Email<br><input type="email" name="email" required value="<?php echo $email; ?>"><br>
    Course<br><input name="course" required value="<?php echo $course; ?>"><br>
    <button type="submit" name="submit">Save</button>
    <button type="button" onclick="location.href='index.php'">Cancel</button>
</form>

</body>
</html>
