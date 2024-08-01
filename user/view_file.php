<?php
// Database connection
$host = 'localhost';
$db = 'dms';
$user = 'root';
$pass = null ;
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

$id = $_GET['id'] ?? null;

if ($id) {

    if ($id) {
        $filePath = $id;

        if (file_exists($filePath)) {
            $mimeType = mime_content_type($filePath);
            header('Content-Type: ' . $mimeType);
            readfile($filePath);
            exit;
        } else {
            echo "File not found on server.";
        }
    } else {
        echo "No file found with the given ID.";
    }
} else {
    echo "No file ID specified.";
}
?>