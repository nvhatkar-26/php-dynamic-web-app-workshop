<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';

$_SESSION = [];

$sessionName = session_name();
$params = session_get_cookie_params();

if ($sessionName !== '' && isset($_COOKIE[$sessionName])) {
    set_cookie_compat(
        $sessionName,
        '',
        time() - 3600,
        $params['path'] ?: '/',
        (string) ($params['domain'] ?? ''),
        (bool) ($params['secure'] ?? false),
        (bool) ($params['httponly'] ?? true)
    );
}

session_destroy();

clear_idle_cookie();

header('Location: login.php');
exit();
