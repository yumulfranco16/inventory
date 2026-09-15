<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add User</title>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width:600px">
            <div class="card-body p-4">
                <h2>Add New User</h2>
                <p class="text-muted">Create an account and assign its access level.</p>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <label class="form-label">Username</label>
                        <input class="form-control mb-3" name="username" minlength="3" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                        <label class="form-label">Password</label>
                        <input class="form-control mb-3" type="password" name="password" minlength="6" required>
                        <label class="form-label">Confirm Password</label>
                        <input class="form-control mb-3" type="password" name="confirm_password" minlength="6" required>
                        <label class="form-label">Role</label><select class="form-select mb-3" name="role">
                        <option value="user">User</option>
                        <option value="admin">Administrator</option>
                    </select><label class="form-label">Status</label><select class="form-select mb-4" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <button class="btn btn-primary">Create User</button> 
                    <a class="btn btn-outline-secondary" href="index.php?action=users">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>