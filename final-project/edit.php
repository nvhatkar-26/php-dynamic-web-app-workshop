<?php
include 'db.php';

$error = '';
$name = '';
$email = '';
$course = '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (isset($_POST['submit'])) {
    $id = (int) ($_POST['id'] ?? 0);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    if ($id < 1) {
        $error = 'Invalid student.';
    } elseif ($name === '' || $email === '' || $course === '') {
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
} elseif ($id >= 1) {
    $stmt = $conn->prepare("SELECT name, email, course FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $name = $row['name'];
        $email = $row['email'];
        $course = $row['course'];
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
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
<p><a href="index.php">Go to Listing Page</a></p>

<?php if ($error != '') echo '<p class="error">' . $error . '</p>'; ?>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Name<br><input name="name" required value="<?php echo $name; ?>"><br>
    Email<br><input type="email" name="email" required value="<?php echo $email; ?>"><br>
    Course<br><input name="course" required value="<?php echo $course; ?>"><br>
    <button type="submit" name="submit">Update</button>
</form>

</body>
</html>
