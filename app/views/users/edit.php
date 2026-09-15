<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit User</title>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width:600px">
            <div class="card-body p-4">
                <h2>Edit User</h2><?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post"><label class="form-label">Username</label><input class="form-control mb-3" name="username" minlength="3" required value="<?= htmlspecialchars($target['username']) ?>"><label class="form-label">Role</label><select class="form-select mb-3" name="role">
                        <option value="user" <?= $target['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $target['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                    </select><label class="form-label">Status</label><select class="form-select mb-4" name="status">
                        <option value="active" <?= $target['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $target['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select><button class="btn btn-primary">Save Changes</button> <a class="btn btn-outline-secondary" href="index.php?action=users">Cancel</a></form>
            </div>
        </div>
    </div>
</body>

</html>