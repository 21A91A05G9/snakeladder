<?php 
$db_server = "mysql-db";
$db_user = "root";
$db_pass = "root";
$db_name = "snake_ladder";
$conn = null;

try {
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
    }
} catch (mysqli_sql_exception $e) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $e->getMessage()]);
}
?>

