<?php
session_start();
require "db.php";

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}

include 'inc/header.php';
?>

<div class="card" style="max-width:420px;margin:40px auto;">
    <h2>Admin Login</h2>
    <?php if($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <label><input type="checkbox" onclick="toggle()"> Show Password</label><br><br>
        <button type="submit">Login</button>
    </form>
</div>

<script>function toggle(){var p=document.getElementById("password");p.type=p.type==='password'?'text':'password'}</script>

<?php include 'inc/footer.php'; ?>