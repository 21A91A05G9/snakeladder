<?php
header('Content-Type: application/json');

// Allow CORS from localhost:3000
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}

include("database.php");

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM logins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the username exists
    if ($stmt->num_rows === 1) {
        echo json_encode(['valid' => true]);
    } else {
        echo json_encode(['valid' => false]);
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    echo json_encode(["error" => "Unable to fetch data"]);
}
?>

