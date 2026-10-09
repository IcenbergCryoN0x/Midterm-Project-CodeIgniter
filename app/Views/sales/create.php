<!DOCTYPE html>
<html>
<head>
    <title>Record Sale</title>
</head>
<body>

<h1>Record Sale</h1>

<a href="<?= site_url('sales') ?>">Back to Sales History</a>

<?php if (session()->getFlashdata('errors')): ?>
    <ul style="color: red;">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;">
        <?= esc(session()->getFlashdata('error')) ?>
    </p>
<?php endif; ?>

<form action="<?= site_url('sales/create') ?>" method="post">

    <?= csrf_field() ?>

    <label>Product:</label><br>
    <select name="product_id" required>
        <option value="">-- Select Product --</option>

        <?php foreach ($products as $product): ?>
            <option value="<?= esc($product['id']) ?>"
                <?= old('product_id') == $product['id'] ? 'selected' : '' ?>>
                <?= esc($product['name']) ?>
                - ₱<?= number_format($product['price'], 2) ?>
                (Stock: <?= esc($product['stock_quantity']) ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Customer:</label><br>
    <select name="customer_id">
        <option value="">Walk-in Customer</option>

        <?php foreach ($customers as $customer): ?>
            <option value="<?= esc($customer['id']) ?>"
                <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>>
                <?= esc($customer['full_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Quantity:</label><br>
    <input type="number"
           name="quantity"
           min="1"
           value="<?= old('quantity', 1) ?>"
           required>
    <br><br>

    <button type="submit">Record Sale</button>
</form>

</body>
</html>