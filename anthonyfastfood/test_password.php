<?php
$hash = '$2y$10$uluVYD1vFhfg1G0VXKR4K.hPlYJBl/mzc/kLNwmMHhMUQ/.V7plNC';
$password = 'Manager@123';

echo "Testing password verification:\n";
echo "Password: $password\n";
echo "Hash: $hash\n";
echo "Result: " . (password_verify($password, $hash) ? 'Success' : 'Failed') . "\n";

// Try with different password
$password2 = 'manager123';
echo "\nTrying with alternative password:\n";
echo "Password: $password2\n";
echo "Result: " . (password_verify($password2, $hash) ? 'Success' : 'Failed') . "\n";
