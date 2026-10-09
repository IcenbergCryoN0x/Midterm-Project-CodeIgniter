<?php

$password = 'Staff123!';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo "Username: staff" . PHP_EOL;
echo "Password: " . $password . PHP_EOL;
echo "Hashed password: " . $hashedPassword . PHP_EOL;