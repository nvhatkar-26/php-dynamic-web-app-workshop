<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/config.php';

$message = '';

if (isset($_GET['registered'])) {
    $message = 'Signup successful. Please login.';
}

if (isset($_GET['timeout'])) {
    $message = 'You were logged out automatically after '
        . LOGIN_IDLE_SECONDS
        . ' seconds of idle time.';
}

/**
 * bcrypt hash unrelated to stored passwords — used only when the user row is missing
 * so password_verify timing does not shortcut on "unknown user".
 */
$dummyVerifier = '$2y$12$zqKj8vQxYqJfN8mH5pLx.uK9nR3sW2tV1zA4bC6dE8fG0hI2jL4';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate()) {
        http_response_code(403);
        $message = 'Invalid session token. Refresh the page and try again.';
    } else {
        $username = isset($_POST['username']) ? trim((string) $_POST['username']) : '';
        $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $storedHash = is_array($user) ? $user['password'] : $dummyVerifier;
        $passwordMatches = password_verify($password, $storedHash);

        if (is_array($user) && $passwordMatches) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            refresh_idle_cookie();
            header('Location: dashboard.php');
            exit();
        }

        $message = 'Invalid username or password.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>

    <?php if ($message !== ''): ?>
        <p class="info"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" autocomplete="username">
        <?php echo csrf_field(); ?>

        <label for="login_username">Username</label>
        <input id="login_username" type="text" name="username" maxlength="100" autocomplete="username" required>

        <label for="login_password">Password</label>
        <input id="login_password" type="password" name="password" autocomplete="current-password" required>

        <button type="submit">Login</button>
    </form>

    <p>New user? <a href="signup.php">Create account</a></p>
</div>
</body>
</html>
