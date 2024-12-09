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

    // Retrieve data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['name'], $data['email'], $data['phone'], $data['subject'])) {
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $subject = $data['subject'];

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO teachers (name, email, phone, subject) VALUES (:name, :email, :phone, :subject)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':subject', $subject);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Teacher registered successfully!']);
        } else {
            echo json_encode(['message' => 'Failed to register teacher.']);
        }
    } else {
        echo json_encode(['message' => 'Invalid input.']);
    }
} catch (PDOException $e) {
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
?>
