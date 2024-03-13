<?php
session_start();
include 'includes.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"]; 

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password (you should use password_verify if passwords are hashed)
        if ($password == $row['password']) {
            // Password is correct, create session and redirect to dashboard or any other page
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.html?message=loginSuccess");
            exit();
        } else {
            // Password is incorrect
            header("Location: login.html?message=incorrectPassword!");
        }
    } else {
        // User does not exist
            header("Location: login.html?message=userNotFound");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
