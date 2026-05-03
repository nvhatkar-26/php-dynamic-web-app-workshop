<?php
include 'db.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id >= 1) {
    $conn->query("DELETE FROM students WHERE id=$id");
}
header("Location: index.php");
exit;
