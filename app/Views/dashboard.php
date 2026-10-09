<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #222;
        }

        header {
            background: #222;
            color: white;
            padding: 20px 30px;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .card {
            display: block;
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-decoration: none;
            color: #222;
            box-shadow: 0 2px 8px #00000012;
        }

        .card:hover {
            background: #e9f1ff;
        }

        .card h3 {
            margin-top: 0;
        }

        .logout {
            margin-top: 30px;
        }

        button {
            padding: 10px 18px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<header>
    <h2>Point-of-Sale System</h2>
    <p>Welcome, <?= esc(session()->get('full_name')) ?>!</p>
</header>

<div class="container">
    <h2>Dashboard</h2>
    <p>Select a module to manage your POS system.</p>

    <div class="menu">
        <a class="card" href="<?= site_url('products') ?>">
            <h3>Products</h3>
            <p>Manage products, prices, stock, and images.</p>
        </a>

        <a class="card" href="<?= site_url('customers') ?>">
            <h3>Customers</h3>
            <p>Manage customer information.</p>
        </a>

        <a class="card" href="<?= site_url('staff') ?>">
            <h3>Staff</h3>
            <p>Manage staff accounts and profiles.</p>
        </a>

        <a class="card" href="<?= site_url('sales') ?>">
            <h3>Sales</h3>
            <p>Record transactions and view sales history.</p>
        </a>
    </div>

    <form class="logout" action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit">Log Out</button>
    </form>
</div>

</body>
</html>