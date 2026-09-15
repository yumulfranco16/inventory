<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Change Password</title>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width:600px">
            <div class="card-body p-4">
                <h2><?= ((int)$targetId === (int)$_SESSION['user_id']) ? 'Change My Password' : 'Reset User Password' ?></h2>
                <p class="text-muted">Account: <strong><?= htmlspecialchars($target['username']) ?></strong></p>
                <?php if ($error): ?>
                    <div class="alert alert-danger"
                    ><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <label class="form-label">New Password</label>
                        <input class="form-control mb-3" type="password" name="password" minlength="6" required>
                        <label class="form-label">Confirm New Password</label>
                        <input class="form-control mb-4" type="password" name="confirm_password" minlength="6" required>
                        <button class="btn btn-primary">Update Password</button> 
                        <a class="btn btn-outline-secondary" href="index.php?action=<?= ((($_SESSION['role'] ?? 'user') === 'admin') ? 'users' : 'dashboard') ?>">Cancel</a>
                    </form>
            </div>
        </div>
    </div>
</body>

</html>