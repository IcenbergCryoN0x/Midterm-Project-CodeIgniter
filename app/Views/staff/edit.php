<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff</title>
</head>
<body>

<h1>Edit Staff Account</h1>

<a href="<?= site_url('staff') ?>">Back to Staff</a>

<?php if (session()->getFlashdata('errors')): ?>
    <ul style="color: red;">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="<?= site_url('staff/update/' . $staff['id']) ?>"
      method="post"
      enctype="multipart/form-data">

    <?= csrf_field() ?>

    <label>Username:</label><br>
    <input type="text"
           name="username"
           value="<?= old('username', $staff['username']) ?>"
           required>
    <br><br>

    <label>Full Name:</label><br>
    <input type="text"
           name="full_name"
           value="<?= old('full_name', $staff['full_name']) ?>"
           required>
    <br><br>

    <label>New Password:</label><br>
    <input type="password"
           name="password">
    <small>Leave blank to keep the current password.</small>
    <br><br>

    <label>Current Avatar:</label><br>

    <?php if (! empty($staff['avatar'])): ?>
        <img src="<?= base_url('uploads/staff/' . $staff['avatar']) ?>"
             width="100"
             height="100"
             style="object-fit: cover;">
    <?php else: ?>
        <p>No avatar uploaded.</p>
    <?php endif; ?>

    <br>

    <label>Replace Avatar:</label><br>
    <input type="file"
           name="avatar"
           accept="image/*">
    <br><br>

    <button type="submit">Update Staff Account</button>
</form>

</body>
</html>