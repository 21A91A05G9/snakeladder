<?php


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

include("database.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $score = 0;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "SELECT * FROM logins WHERE username = '$username'";
        $statement = mysqli_query($conn, $sql);

        if (mysqli_num_rows($statement) == 1) {
            echo "Username exists!";
        } else {
            echo $username;
            $sql = "INSERT INTO logins (username, password, email, score) VALUES ('$username', '$hashed_password', '$email', '$score')";
            try {
                if (mysqli_query($conn, $sql)) {
                    echo "Successful registration";
                }
            } catch (mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
        }

        mysqli_close($conn);
    } else {
        echo "Submit button not clicked.";
    }
} else {
    echo "Only POST requests are allowed for this endpoint.";
}
?>