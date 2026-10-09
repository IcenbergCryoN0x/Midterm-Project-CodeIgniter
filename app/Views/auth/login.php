<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Staff Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            width: 320px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 12px 0 5px;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }

        .error {
            color: #b91c1c;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>POS Staff Login</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <p class="error">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   required autocomplete="username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   required autocomplete="current-password">

            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>