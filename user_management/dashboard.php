<?php

declare(strict_types=1);

require_once __DIR__ . '/auth_check.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome,
        <?php echo $_SESSION['username']; ?>!</h2>

    <p>You are logged in successfully.</p>
    <p>Your login idle cookie expires after <strong><?php echo (int) LOGIN_IDLE_SECONDS; ?></strong> seconds.</p>
    <p>If you do not refresh or open another protected page within that time,
        you will be logged out automatically.</p>

    <a class="button-link" href="dashboard.php">Refresh Activity</a>
    <a class="logout" href="logout.php">Logout</a>
</div>
</body>
</html>
