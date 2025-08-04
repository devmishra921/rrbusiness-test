<?php
// db_connect.php
$host = 'sql110.infinityfree.com';
$user = 'if0_39236898';
$pass = 'Rrbusiness2025';
$db   = 'if0_39236898_rrbusiness';  // जो तूने बनाया है

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

