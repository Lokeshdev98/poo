<?php
// Database connection variables
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default is empty in XAMPP
$dbname = "donations";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Handling file upload
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["paymentFile"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["paymentFile"]["tmp_name"], $targetFilePath)) {
        // Inserting data into the database
        $sql = "INSERT INTO payments (name, email, payment_file) VALUES ('$name', '$email', '$targetFilePath')";

        if ($conn->query($sql) === TRUE) {
            echo "Payment details uploaded successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>