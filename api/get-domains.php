<?php
require_once '../config.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Fetch all domain names from the database
try {
    $stmt = $pdo->prepare("SELECT domain_name FROM domains");
    $stmt->execute();
    $domains = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo json_encode([
        'status' => 'success',
        'data' => $domains,
        'count' => count($domains)
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
