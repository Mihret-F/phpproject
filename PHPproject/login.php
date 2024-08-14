<?php
include('include/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get username, user type and password from form
  $username = $_POST['username'];
  $password = $_POST['password'];
  $userType = $_POST['user-type'];

  // Check if user exists in database
  $sql = "SELECT * FROM staff_members WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // User exists in database, redirect based on selected user type
    switch ($userType) {
      case 'doctor':
        header('Location: docthom.php');
        break;
      case 'LabTech':
        header('Location: LabTechHome.php');
        break;
      case 'reception':
        header('Location: RecepHome.php');
        break;
      case 'phy_assist':
        header('Location: PhysicianAss_Home.php');
        break;
      default:
        echo "Invalid user type";
    }
  } else {
    echo "Invalid username or password";
  }
  
}
$conn->close();
?>