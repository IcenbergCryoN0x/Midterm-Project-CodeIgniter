<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p style="color:red;"><?= esc($error) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="<?= site_url('products/create') ?>"
          method="post" enctype="multipart/form-data">

        <?= csrf_field() ?>

        <label>Product Name</label><br>
        <input type="text" name="name"
               value="<?= old('name') ?>" required>
        <br><br>

        <label>Price</label><br>
        <input type="number" name="price" step="0.01"
               min="0" value="<?= old('price') ?>" required>
        <br><br>

        <label>Stock Quantity</label><br>
        <input type="number" name="stock_quantity"
               min="0" step="1" value="<?= old('stock_quantity', '0') ?>" required>
        <br><br>

        <label>Product Image (optional, max 2 MB)</label><br>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        <br><br>

        <button type="submit">Save Product</button>
        <a href="<?= site_url('products') ?>">Cancel</a>
    </form>
</body>
</html>