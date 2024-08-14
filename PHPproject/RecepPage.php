<?php
include('include/connection.php');
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
    echo '<title>Receptionist Page</title>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="stylesheet" href="css/RecepPage.css">';
echo '</head>';
echo '<body>';
include 'include/RecepHeader.php';
echo '<div class="containr">';
echo '<h2>Search for Existing Patient</h2>';
echo '<form method="GET" action="" onsubmit="return validatePatientSearchForm();">';
echo '<label for="search">Search:</label>';
echo '<input type="text" name="search" id="search"><br>';
echo '<input type="submit" value="Submit">';
echo '</form>';
echo '<hr>';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($conn, $_GET['search']);
        $sql = "SELECT * FROM patients WHERE id = '$search'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Display patient details
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>Name: " . $row['name'] . "</p>";
                echo "<p>Date of Birth: " . $row['dob'] . "</p>";
                echo "<p>Gender: " . $row['gender'] . "</p>";
                echo "<p>Email: " . $row['email'] . "</p>";
                echo "<p>Phone: " . $row['phone'] . "</p>";
            }
        }
        else {
            echo "No patients found with that ID";
        }
    }
}
echo '<br>';
echo '<br>';
echo '<form action="" method="post" onsubmit="return validateForm()">';
echo '<h2>Register New Patient</h2>';
echo '<label for="name">Name:</label>';
echo '<input type="text" name="name" id="name" required><br>';
echo '<label for="dob">Date of Birth:</label>';
echo '<input type="date" name="dob" id="dob" required><br>';
echo '<label for="gender">Gender:</label>';
echo '<select name="gender" id="gender">';
echo '<option value="" disabled selected>Select gender</option>';
echo '<option value="F">Female</option>';
echo '<option  value="M">Male</option>';
echo '</select>';
echo '<br>';
echo '<label for="email">Email:</label>';
echo '<input type="email" name="email" id="email" required><br>';
echo '<label for="phone">Phone Number:</label>';
echo '<input type="tel" name="phone" id="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required><br>';
echo '<input type="submit" name ="register" value="Register">';
echo '</form>';

if (isset($_POST['register'])) {
    // Get form data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Create SQL INSERT statement
    $sql = "INSERT INTO patients (name, dob, gender, email, phone) VALUES ('$name', '$dob', '$gender', '$email', '$phone')";

    // Execute SQL statement
    if ($conn->query($sql) == TRUE) {
        echo "<p>New patient record created successfully.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
echo '</div>';
echo '<script src="js/Recep.js"></script>';
echo '<script src="js/search.js"></script>';
include 'include/footer.php';
echo '</body>';
echo '</html>';

// Close database connection
$conn->close();