<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";  // Your MySQL password
$db_name = "snake&ladder";
$db_port = 3306;  // Default MySQL port on Windows

$conn = null;

try {
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name, $db_port);
    if ($conn->connect_error) {
        die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
    }
    echo json_encode(["status" => "success", "message" => "Connected to database successfully"]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $e->getMessage()]);
}
?>
