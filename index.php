<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["submit"])) {
        $response = [];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $score = 0;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql_check = "SELECT * FROM logins WHERE username = '$username'";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $response['status'] = 'Error';
            $response['message'] = 'Username already exists.';
            echo json_encode($response);
        } else {
            $sql_insert = "INSERT INTO logins (username, password, email, score) VALUES ('$username', '$hashed_password', '$email', '$score')";
            if (mysqli_query($conn, $sql_insert)) {
                $response['status'] = 'Success';
                $response['message'] = 'Registration successful.';
                echo json_encode($response);
            } else {
                $response['status'] = 'Error';
                $response['message'] = 'Error occurred while registering user.';
                echo json_encode($response);
            }
        }

        mysqli_close($conn);
    } else {
        echo json_encode(['status' => 'Error', 'message' => 'Submit button not clicked.']);
    }
} else {
    echo json_encode(['status' => 'Error', 'message' => 'Only POST requests are allowed for this endpoint.']);
}
?>
