<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f3f4f6;
        }

        h1 {
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: white;
        }

        .empty {
            text-align: center;
            color: #666;
        }

        a {
            color: #2563eb;
        }

        .button {
            display: inline-block;
            padding: 7px 12px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .edit-button {
            background: #2563eb;
        }

        .delete-button {
            background: #dc2626;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            background: #dcfce7;
            color: #166534;
            border-radius: 5px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .add-button {
            background: #16a34a;
            margin-bottom: 15px;
        }

        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }

        form {
            display: inline;
        }
    </style>
</head>
<body>

    <h1>Product Management</h1>

    <p>
        <a href="<?= site_url('dashboard') ?>">Back to Dashboard</a>
    </p>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="message">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="message error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <p>
        <a class="button add-button" href="<?= site_url('products/new') ?>">
            + Add Product
        </a>
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock Quantity</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (! empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= esc($product['id']) ?></td>

                        <td><?= esc($product['name']) ?></td>

                        <td>
                            ₱<?= number_format((float) $product['price'], 2) ?>
                        </td>

                        <td><?= esc($product['stock_quantity']) ?></td>

                        <td>
                            <?php if (! empty($product['image'])): ?>
                                <img
                                    src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                    alt="Product image"
                                >
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>

                        <td>
                            <a
                                class="button edit-button"
                                href="<?= site_url('products/edit/' . $product['id']) ?>">
                                Edit
                            </a>

                            <form
                                action="<?= site_url('products/delete/' . $product['id']) ?>"
                                method="post"
                                onsubmit="return confirm('Are you sure you want to delete this product?');">

                                <?= csrf_field() ?>

                                <button
                                    class="button delete-button"
                                    type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="empty">
                        No products found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>