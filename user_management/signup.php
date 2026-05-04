<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        http_response_code(403);
        $message = 'Invalid session token. Refresh the page and try again.';
    } else {
        $username = isset($_POST['username']) ? trim((string) $_POST['username']) : '';
        $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

        $validPattern = preg_match('/^[a-zA-Z0-9_-]{3,100}$/', $username) === 1;
        $passwordAcceptable = strlen($password) >= 8 && strlen($password) <= 72;

        if (!$validPattern || $username === '') {
            $message = 'Username must be 3–100 characters and use only letters, numbers, hyphen, or underscore.';
        } elseif (!$passwordAcceptable) {
            $message = 'Password must be between 8 and 72 characters.';
        } else {
            try {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
                $stmt->execute([$username, $hashedPassword]);

                header('Location: login.php?registered=1');
                exit();
            } catch (PDOException $e) {
                $sqlState = isset($e->errorInfo[0]) ? (string) $e->errorInfo[0] : '';
                $drvCode = isset($e->errorInfo[1]) ? (int) $e->errorInfo[1] : 0;
                if ($sqlState === '23000' || $drvCode === 1062) {
                    $message = 'Username already exists.';
                } else {
                    error_log($e->getMessage());
                    $message = 'Signup failed. Please try again later.';
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Create Account</h2>

    <?php if ($message !== ''): ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" autocomplete="username">
        <?php echo csrf_field(); ?>

        <label for="signup_username">Username</label>
        <input id="signup_username" type="text" name="username" maxlength="100" autocomplete="username" required>

        <label for="signup_password">Password</label>
        <input id="signup_password" type="password" name="password" minlength="8" maxlength="72"
               autocomplete="new-password" required>

        <button type="submit">Sign Up</button>
    </form>

    <p>Already registered? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
