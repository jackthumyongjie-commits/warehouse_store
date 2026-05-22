<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$base = '/project/store';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="<?= $base ?>/admin/assets/css/admin.css">
    <title>Store</title>
</head>
<body>
<header class="admin-header">
    <div class="container">
        <h1>Store Admin</h1>
        <nav class="admin-nav">
            <?php if (isset($_SESSION['admin'])): ?>
                <a href="<?= $base ?>/admin/admin_dashboard.php">Dashboard</a>
                <a href="<?= $base ?>/admin/logout.php">Logout</a>
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <a href="<?= $base ?>/user/user_dashboard.php">Dashboard</a>
                <a href="<?= $base ?>/user/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $base ?>/user/user_login.php">User Login</a>
                <a href="<?= $base ?>/admin/admin_login.php">Admin Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
