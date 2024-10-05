<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$dbSettings = [
    'host' => 'localhost',
    'dbname' => 'smartlift',
    'user' => 'root',
    'pass' => 'kuse@fse2018',
];

$app = new \Slim\App;

$app->get('/lift/{org_id}', function (Request $request, Response $response) use ($dbSettings) {
    $id = $request->getAttribute('org_id');
    $pdo = new PDO("mysql:host=" . $dbSettings['host'] . ";dbname=" . $dbSettings['dbname'], $dbSettings['user'], $dbSettings['pass']);
    
    $stmt = $pdo->prepare("SELECT * FROM `lifts` WHERE org_id = ?");
    $stmt->execute([$org_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $response->withJson($result, 200);
});

$app->run();

