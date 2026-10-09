<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
</head>
<body>

<h1>Customer Management</h1>

<a href="<?= site_url('dashboard') ?>">Dashboard</a>
<a href="<?= site_url('customers/new') ?>">Add Customer</a>

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
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date Added</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (! empty($customers)): ?>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= esc($customer['id']) ?></td>
                    <td><?= esc($customer['full_name']) ?></td>
                    <td><?= esc($customer['email']) ?></td>
                    <td><?= esc($customer['phone'] ?? 'N/A') ?></td>
                    <td><?= esc($customer['created_at']) ?></td>
                    <td>
                        <a href="<?= site_url('customers/edit/' . $customer['id']) ?>">
                            Edit
                        </a>

                        <form action="<?= site_url('customers/delete/' . $customer['id']) ?>"
                              method="post"
                              style="display: inline;"
                              onsubmit="return confirm('Delete this customer?');">

                            <?= csrf_field() ?>

                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No customers found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>