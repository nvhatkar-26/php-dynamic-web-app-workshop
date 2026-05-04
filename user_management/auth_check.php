<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_COOKIE['login_idle'])) {
    session_unset();
    session_destroy();
    clear_idle_cookie();
    header('Location: login.php?timeout=1');
    exit();
}

refresh_idle_cookie();
