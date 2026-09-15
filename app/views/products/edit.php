<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<?php if (isset($error)): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Product Name</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
    <br><br>

    <label>Price</label><br>
    <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>"
           step="0.01" min="0" required>
    <br><br>

    <p><strong>Current Stock:</strong> <?= (int) $product['stock'] ?></p>
    <p>Stock is changed using Stock In / Stock Out so that inventory transactions remain accurate.</p>

    <button type="submit">Update Product</button>
</form>

<br>
<a href="index.php?action=products">Back</a>

</body>
</html>
