<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

include("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];
    $username = $_POST["username"] ;
    $password = $_POST["password"] ;

    $sql = "SELECT * FROM logins WHERE username = '$username'";
    $statement = mysqli_query($conn, $sql);

    if (mysqli_num_rows($statement) == 1) {
        $row = mysqli_fetch_assoc($statement);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $response['status'] = 'Success';
            $response['message'] = 'Login successful';
        } 
        else {
            $response['status'] = 'Error';
            $response['message'] = 'Incorrect password';
        }
    } 
    else {
        $response['status'] = 'Error';
        $response['message'] = 'Username not found';
    }

    echo json_encode($response);
    mysqli_close($conn);
} 
else {
    echo json_encode(['status' => 'Error', 'message' => 'Only POST requests are allowed for this endpoint']);
}
?>
