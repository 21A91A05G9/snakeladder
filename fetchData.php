<?php  
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

include("database.php");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username'])) {
    $username = $data['username'];

    // Get the rank of the user based on their score
    $sql = "
        SELECT username, score,
               (SELECT COUNT(DISTINCT score) + 1 
                FROM logins 
                WHERE score > l.score) AS rank
        FROM logins l
        WHERE username = '$username'
    ";
    
    $statement = mysqli_query($conn, $sql);
   
    if ($statement && mysqli_num_rows($statement) == 1) {
        $row = mysqli_fetch_assoc($statement);
        echo json_encode(["rank" => $row['rank']]);
    } else {
        echo json_encode(["message" => "User not found or no rank data available."]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input."]);
}
?>
