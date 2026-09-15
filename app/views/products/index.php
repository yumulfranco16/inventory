<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>

<body>

<h1>Products</h1>

<a href="index.php?action=dashboard">
    Dashboard
</a>

|

<a href="index.php?action=create">
    Add Product
</a>

|

<form method="POST" action="index.php?action=logout" style="display:inline;" onsubmit="return confirm('Are you sure you want to logout?');">
    <button type="submit">Logout</button>
</form>

<br><br>

<table border="1" cellpadding="8">

<tr>
    <th>ID</th>
    <th>Product</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Stock In</th>
    <th>Stock Out</th>
    <th>Actions</th>
</tr>

<?php foreach ($products as $product): ?>

<tr>

<td>
    <?= $product['id'] ?>
</td>

<td>
    <?= htmlspecialchars($product['name']) ?>
</td>

<td>
    ₱<?= number_format($product['price'], 2) ?>
</td>

<td>
    <?= $product['stock'] ?>
</td>

<td>

<form method="POST"
      action="index.php?action=stock_in">

    <input type="hidden"
           name="id"
           value="<?= $product['id'] ?>">

    <input type="number"
           name="quantity"
           min="1"
           required>

    <button type="submit">
        Stock In
    </button>

</form>

</td>

<td>

<form method="POST"
      action="index.php?action=stock_out">

    <input type="hidden"
           name="id"
           value="<?= $product['id'] ?>">

    <input type="number"
           name="quantity"
           min="1"
           required>

    <button type="submit">
        Stock Out
    </button>

</form>

</td>

<td>
    <a href="index.php?action=edit&id=<?= (int) $product['id'] ?>">
        Edit
    </a>

    |

    <form method="POST"
          action="index.php?action=delete"
          style="display:inline;"
          onsubmit="return confirm('Delete this product? This cannot be undone.');">
        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
        <button type="submit">Delete</button>
    </form>
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>