<?php
// Include the database connection file
include('connection.php');

// Get form data
$name = $_POST['name'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Create SQL INSERT statement
$sql = "INSERT INTO patients (name, dob, gender, email, phone)
VALUES ('$name', '$dob', '$gender', '$email', '$phone')";

// Execute SQL statement
if ($conn->query($sql) == TRUE) {
  echo "<p>New patient record created successfully.</p>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>