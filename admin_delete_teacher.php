<?php
header('Content-Type: application/json');

// Database credentials
$host = 'localhost';
$dbname = 'teacher_registration';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['id'])) {
        $id = $data['id'];

        $stmt = $conn->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Teacher deleted successfully!']);
        } else {
            echo json_encode(['message' => 'Failed to delete teacher.']);
        }
    } else {
        echo json_encode(['message' => 'Invalid input.']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
