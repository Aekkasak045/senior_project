<?php
header("Content-Type: application/json");

//connect Database 
$host = 'localhost';
$db   = 'smartlift';
$user = 'root';
$pass = 'kuse@fse2018';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->prepare("SELECT * FROM `lifts` WHERE org_id = ?");
$stmt->execute([3]);
$result = $stmt->fetch();

echo json_encode($result);
?>

