<?php
require __DIR__ . '/../admin/db.php';

include __DIR__ . '/../admin/inc/header.php';

$error = '';
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 4) {
        $error = 'Password must be at least 4 characters.';
    } else {
        // Check existing username
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Username already taken.';
        } else {
            $hash = md5($password);
            $ins = $conn->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, "user")');
            $ins->bind_param('ss', $username, $hash);
            if ($ins->execute()) {
                header('Location: user_login.php?registered=1');
                exit();
            } else {
                $error = 'Registration failed.';
            }
        }
    }
}
?>

<div style="max-width:480px;margin:28px auto;padding:16px;border:1px solid #eee;border-radius:8px;background:#fff">
    <h2>User Register</h2>
    <?php if ($error): ?><div style="color:#b91c1c;margin-bottom:8px"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required style="width:100%;padding:8px;margin-bottom:8px"><br>
        <input type="password" name="password" id="pw" placeholder="Password" required style="width:100%;padding:8px;margin-bottom:8px"><br>
        <input type="password" name="confirm" placeholder="Confirm Password" required style="width:100%;padding:8px;margin-bottom:8px"><br>
        <label><input type="checkbox" onclick="toggle()"> Show Password</label><br><br>
        <button type="submit" name="register" style="padding:10px 14px;background:#2b7cff;color:#fff;border:0;border-radius:6px">Register</button>
        <a href="user_login.php" style="margin-left:8px;color:#6b7280;text-decoration:none">Back to Login</a>
    </form>
</div>

<?php include __DIR__ . '/../admin/inc/footer.php'; ?>

<script>function toggle(){let p=document.getElementById('pw');p.type=p.type==='password'?'text':'password'}</script>