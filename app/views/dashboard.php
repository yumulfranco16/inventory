<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Inventory Dashboard</title>
    <link href="" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container"><a class="navbar-brand" href="index.php?action=dashboard">Inventory System</a>
            <div class="text-white">Welcome, <?= htmlspecialchars($_SESSION['username']) ?> 
            <span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($_SESSION['role'] ?? 'user')) ?></span>
                <form method="POST" action="index.php?action=logout" class="d-inline ms-2" onsubmit="return confirm('Are you sure you want to logout?');">
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button></form>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Products</h5>
                        <!-- <p class="text-muted">Manage products, pricing, and inventory.</p> -->
                        <a class="btn btn-primary" href="index.php?action=products">Open Products</a>
                    </div>
                </div>
            </div>
            <?php if (($_SESSION['role'] ?? 'user') === 'admin'): ?><div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>User Management</h5>
                            <!-- <p class="text-muted">Add users, assign roles, activate/deactivate accounts, and reset passwords.</p> -->
                            <a class="btn btn-success" href="index.php?action=users">Manage Users</a>
                        </div>
                    </div>
                </div><?php endif; ?>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>My Account</h5>
                        <!-- <p class="text-muted">Update your account password.</p> -->
                        <a class="btn btn-outline-secondary" href="index.php?action=change_password">Change My Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>