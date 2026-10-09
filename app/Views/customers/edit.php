<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
</head>
<body>

<h1>Edit Customer</h1>

<a href="<?= site_url('customers') ?>">Back to Customers</a>

<?php if (session()->getFlashdata('errors')): ?>
    <ul style="color: red;">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= site_url('customers/update/' . $customer['id']) ?>"
      method="post">

    <?= csrf_field() ?>

    <label>Full Name:</label><br>
    <input type="text"
           name="full_name"
           value="<?= old('full_name', $customer['full_name']) ?>"
           required>
    <br><br>

    <label>Email:</label><br>
    <input type="email"
           name="email"
           value="<?= old('email', $customer['email']) ?>"
           required>
    <br><br>

    <label>Phone:</label><br>
    <input type="text"
           name="phone"
           value="<?= old('phone', $customer['phone']) ?>">
    <br><br>

    <button type="submit">Update Customer</button>
</form>

</body>
</html>