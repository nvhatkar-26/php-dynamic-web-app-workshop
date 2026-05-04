<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/session.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit();
