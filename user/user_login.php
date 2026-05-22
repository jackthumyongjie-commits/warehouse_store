<?php
session_start();
require __DIR__ . '/../admin/db.php';

include __DIR__ . '/../admin/inc/header.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            AND password='$password' 
            AND role='user'";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: user_dashboard.php");
    } else {
        echo "Invalid login";
    }
}
?>

<form method="POST">
    <h2>User Login</h2>

    <input type="text" name="username" placeholder="Username"><br><br>

    <input type="password" name="password" id="pw">
    <label><input type="checkbox" onclick="toggle()"> Show Password</label><br><br>

    <?php if (isset($_GET['registered'])): ?>
        <div style="color:green;margin-bottom:8px">Registered successfully, please log in.</div>
    <?php endif; ?>

    <button type="submit" name="login">Login</button>
</form>

<script>
function toggle(){
    let p = document.getElementById("pw");
    p.type = p.type === "password" ? "text" : "password";
}
</script>

<div style="max-width:480px;margin:12px auto;text-align:center">
    <span>Don't have an account?</span>
    <a href="user_register.php" style="margin-left:8px;color:#2b7cff">Register</a>
</div>

<?php include __DIR__ . '/../admin/inc/footer.php'; ?>