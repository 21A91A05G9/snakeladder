<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include("database.php");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['score'])) {
    $username = $data['username'];
    $score = $data['score'];
    
    
    // Define the possible scores array
    echo $score;
    $scores = [5000, 2000, 1000, 500, 100];
    
    // Check if score is in the scores array
    if (isset($scores[$score])) {
        // Prepare and execute the select statement
        $stmt = $conn->prepare("SELECT * FROM logins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            $newScore = $scores[$score] + $row["score"];
            
            // Prepare and execute the update statement
            $updateStmt = $conn->prepare("UPDATE logins SET score = ? WHERE username = ?");
            $updateStmt->bind_param("is", $newScore, $username);
            if ($updateStmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Score updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update score."]);
            }
            $updateStmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid username or score."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid score."]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input."]);
}
?>
