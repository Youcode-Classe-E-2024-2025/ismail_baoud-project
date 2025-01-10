<?php
// Get raw POST data
   $data = array(
       'key1' => 'value1',
       'key2' => 'value2'
   );

   header('Content-Type: application/json'); // Crucial!
   echo json_encode($data);
   
// Check if data is valid
if (isset($decodedData['taskId']) && isset($decodedData['newStatus'])) {
    $taskId = $decodedData['taskId'];
    $newStatus = $decodedData['newStatus'];

    // Database connection
    $res = new ConnectionDB();
    $pdo = $res->getConnection();

    // Prepare the SQL statement to update the status
    $stmt = $pdo->prepare('UPDATE tasks SET status = :status WHERE id = :id');
    $stmt->bindParam(':status', $newStatus);
    $stmt->bindParam(':id', $taskId);

    try {
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Task updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update task']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
}
?>
