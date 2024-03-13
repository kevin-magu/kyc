<?php
include('includes.php');
ini_set('display_errors', 1);
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $addresss = $_POST["addresss"];
    $idDocument = $_POST["idDocument"];
    $password = $_POST["password"];


    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (fullName, email, phone, addresss, idDocument,password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullName, $email, $phone, $addresss, $idDocument, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
