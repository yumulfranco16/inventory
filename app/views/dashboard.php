<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>

<body>

<h1>Inventory Dashboard</h1>

<p>
    Welcome,
    <?= htmlspecialchars($_SESSION['username']) ?>
</p>

<a href="index.php?action=products">
    Products
</a>

<br><br>

<a href="index.php?action=logout">
    Logout
</a>

</body>
</html>