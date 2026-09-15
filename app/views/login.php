<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Inventory System</title>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width:420px">
            <div class="card-body p-4">
                <h2 class="mb-1">Inventory System</h2>
                <p class="text-muted">Sign in to continue</p><?php if (isset($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
                    <form method="post">
                        <label class="form-label">Username</label>
                        <input class="form-control mb-3" name="username" required autofocus>
                        <label class="form-label">Password</label><input class="form-control mb-4" type="password" name="password" required>
                        <button class="btn btn-primary w-100">Login</button></form>
            </div>
        </div>
    </div>
</body>

</html>