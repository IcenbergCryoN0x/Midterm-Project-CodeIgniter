<!DOCTYPE html>
<html>
<head>
    <title>Staff Management</title>
</head>
<body>

<h1>Staff Management</h1>

<a href="<?= site_url('dashboard') ?>">Dashboard</a>
<a href="<?= site_url('staff/new') ?>">Add Staff</a>

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
            <th>Avatar</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($staff as $member): ?>
            <tr>
                <td><?= esc($member['id']) ?></td>

                <td>
                    <?php if (! empty($member['avatar'])): ?>
                        <img src="<?= base_url('uploads/staff/' . $member['avatar']) ?>"
                             width="60"
                             height="60"
                             style="object-fit: cover;">
                    <?php else: ?>
                        No avatar
                    <?php endif; ?>
                </td>

                <td><?= esc($member['username']) ?></td>
                <td><?= esc($member['full_name']) ?></td>
                <td><?= esc($member['created_at']) ?></td>

                <td>
                    <a href="<?= site_url('staff/edit/' . $member['id']) ?>">
                        Edit
                    </a>

                    <form action="<?= site_url('staff/delete/' . $member['id']) ?>"
                          method="post"
                          style="display: inline;"
                          onsubmit="return confirm('Delete this staff account?');">

                        <?= csrf_field() ?>

                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>