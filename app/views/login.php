<!DOCTYPE html>
<html>
<head>
    <title>Inventory Login</title>
</head>

<body>

<h2>Inventory System</h2>

<?php if (isset($error)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label>Username</label><br>
    <input type="text" name="username" required>

    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

</body>
</html>