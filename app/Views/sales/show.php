<!DOCTYPE html>
<html>
<head>
    <title>Sale Details</title>
</head>
<body>

<h1>Sale Details</h1>

<a href="<?= site_url('sales') ?>">Back to Sales History</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Sale ID</th>
        <td><?= esc($sale['id']) ?></td>
    </tr>

    <tr>
        <th>Product</th>
        <td><?= esc($sale['product_name']) ?></td>
    </tr>

    <tr>
        <th>Customer</th>
        <td><?= esc($sale['customer_name'] ?? 'Walk-in Customer') ?></td>
    </tr>

    <tr>
        <th>Quantity</th>
        <td><?= esc($sale['quantity']) ?></td>
    </tr>

    <tr>
        <th>Total Price</th>
        <td>₱<?= number_format($sale['total_price'], 2) ?></td>
    </tr>

    <tr>
        <th>Sold By</th>
        <td><?= esc($sale['staff_name']) ?></td>
    </tr>

    <tr>
        <th>Date Recorded</th>
        <td><?= esc($sale['created_at']) ?></td>
    </tr>
</table>

</body>
</html>