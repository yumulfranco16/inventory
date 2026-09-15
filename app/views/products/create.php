<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>

<body>

<h1>Add Product</h1>

<?php if (isset($error)): ?>

<p style="color:red;">
    <?= htmlspecialchars($error) ?>
</p>

<?php endif; ?>

<form method="POST">

    <label>Product Name</label><br>

    <input type="text"
           name="name"
           required>

    <br><br>

    <label>Price</label><br>

    <input type="number"
           name="price"
           step="0.01"
           min="0"
           required>

    <br><br>

    <label>Initial Stock</label><br>

    <input type="number"
           name="stock"
           min="0"
           required>

    <br><br>

    <button type="submit">
        Save
    </button>

</form>

<br>

<a href="index.php?action=products">
    Back
</a>

</body>
</html>