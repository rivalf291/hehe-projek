<?php
require_once '../config.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get the input data
$data = json_decode(file_get_contents("php://input"), true);
$domain_name = $data['domain_name'] ?? '';
$status = $data['status'] ?? '';

// Validate input
if (empty($domain_name) || empty($status)) {
    echo json_encode(['status' => 'error', 'message' => 'Domain name and status are required.']);
    exit;
}

// Update the domain status in the database
try {
    $stmt = $pdo->prepare("UPDATE domains SET status = ? WHERE domain_name = ?");
    $stmt->execute([$status, $domain_name]);
    
    echo json_encode(['status' => 'success', 'message' => 'Domain status updated successfully.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
