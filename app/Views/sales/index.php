<!DOCTYPE html>
<html>
<head>
    <title>Sales History</title>
</head>
<body>

<h1>Sales History</h1>

<a href="<?= site_url('dashboard') ?>">Dashboard</a>
<a href="<?= site_url('sales/new') ?>">Record New Sale</a>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;">
        <?= esc(session()->getFlashdata('success')) ?>
    </p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;">
        <?= esc(session()->getFlashdata('error')) ?>
    </p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Sold By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if (! empty($sales)): ?>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= esc($sale['id']) ?></td>
                    <td><?= esc($sale['product_name']) ?></td>
                    <td><?= esc($sale['customer_name'] ?? 'Walk-in Customer') ?></td>
                    <td><?= esc($sale['quantity']) ?></td>
                    <td>₱<?= number_format($sale['total_price'], 2) ?></td>
                    <td><?= esc($sale['staff_name']) ?></td>
                    <td><?= esc($sale['created_at']) ?></td>
                    <td>
                        <a href="<?= site_url('sales/' . $sale['id']) ?>">
                            View Details
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No sales recorded yet.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>