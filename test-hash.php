<?php
// test-hash.php — genera un hash para "admin123"
$plain = "admin123";
$hash = password_hash($plain, PASSWORD_DEFAULT);
echo "Plain: " . $plain . "<br>";
echo "Hash: " . $hash . "<br>";
echo "Length: " . strlen($hash) . "<br>";
