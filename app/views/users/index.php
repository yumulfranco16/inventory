<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>User Management</title>
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1>User Management</h1>
                <p class="text-muted mb-0">Administrators only</p>
            </div>
            <div><a class="btn btn-outline-secondary" href="index.php?action=dashboard">Dashboard</a> <a class="btn btn-primary" href="index.php?action=create_user">+ Add New User</a></div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody><?php foreach ($users as $u): ?><tr>
                                    <td><?= intval($u['id']) ?></td>
                                    <td><strong><?= htmlspecialchars($u['username']) ?></strong><?= intval($u['id']) === intval($_SESSION['user_id']) ? ' <span class="badge bg-info">You</span>' : '' ?></td>
                                    <td><span class="badge <?= $u['role'] === 'admin' ? 'bg-primary' : 'bg-secondary' ?>"><?= htmlspecialchars(ucfirst($u['role'])) ?></span></td>
                                    <td><span class="badge <?= $u['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>"><?= htmlspecialchars(ucfirst($u['status'])) ?></span></td>
                                    <td><?= htmlspecialchars($u['created_at']) ?></td>
                                    <td><a class="btn btn-sm btn-outline-primary" href="index.php?action=edit_user&id=<?= $u['id'] ?>">Edit</a> <a class="btn btn-sm btn-outline-warning" href="index.php?action=change_password&id=<?= $u['id'] ?>">Reset Password</a> <?php if ($u['id'] !== $_SESSION['user_id']): ?><form method="post" action="index.php?action=toggle_user_status" class="d-inline"><input type="hidden" name="id" value="<?= $u['id'] ?>"><button class="btn btn-sm btn-outline-secondary" onclick="return confirm('Change this user status?')"><?= $u['status'] === 'active' ? 'Deactivate' : 'Activate' ?></button></form>
                                            <form method="post" action="index.php?action=delete_user" class="d-inline"><input type="hidden" name="id" value="<?= $u['id'] ?>"><button class="btn btn-sm btn-outline-danger" onclick="return confirm('Permanently delete this user?')">Delete</button></form><?php endif; ?>
                                    </td>
                                </tr><?php endforeach; ?></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>