<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering
ob_start();

// Log the request method
error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = file_get_contents('php://input');
    error_log('Raw POST data: ' . $data); // Log the raw POST data
    $decodedData = json_decode($data, true);

    // Check if taskId and newStatus are set
    if (isset($decodedData['taskId']) && isset($decodedData['newStatus'])) {
        $taskId = $decodedData['taskId'];
        $newStatus = $decodedData['newStatus'];

        // Database connection
        try {
            $res = new ConnectionDB();
            $pdo = $res->getConnection();

            // Prepare the SQL statement to update the task status
            $stmt = $pdo->prepare('UPDATE tache SET status = :status WHERE id = :id');
            $stmt->bindParam(':status', $newStatus);
            $stmt->bindParam(':id', $taskId);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Task updated successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update task'];
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage()); // Log database errors
            $response = ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    } else {
        $response = ['success' => false, 'message' => 'Invalid data received'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method'];
}

// Set the response header to JSON
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);

// Clean the output buffer and stop buffering
ob_end_flush();
?>