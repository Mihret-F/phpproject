<?php
// Include the database connection file
include('connection.php');

// Check if a specific patient ID is provided
$searchId = isset($_GET['search']) ? $_GET['search'] : '';

if(empty($searchId)) {
    // Display patient search form if no patient ID is provided
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>Patient Records</title>';
    echo '<link rel="stylesheet" href="css/patient.css">';
    echo '</head>';
    echo '<body>';
    include 'header.php';
    echo '<div class="container">';
    echo '<form method="GET" action="">';
    echo '<input type="text" name="search" placeholder="Enter Patient ID">';
    echo '<button type="submit">Search</button>';
    echo '</form>';
    echo '</body>';
    echo '</html>';
    exit;
}

if (isset($_POST['Save'])) {
    // Get the selected patient IDs
    $selectedPatients = isset($_POST['select']) ? $_POST['select'] : array();

    // Get the history entered in the text box
    $historyRecord = isset($_POST['history']) ? $_POST['history'] : '';

    // Update the History column for each selected patient
    foreach ($selectedPatients as $patientID) {
        $sql = "UPDATE patients SET History = '$historyRecord' WHERE id = '$patientID'";
        $result = $conn->query($sql);
        
        if ($result) {
            echo '<p>Patient records updated successfully!</p>';
        }
    }
}

// Create SQL SELECT statements
$sqlPatients = "SELECT * FROM patients";

// Modify the SQL query to search for the specific patient ID if provided
if (!empty($searchId)) {
    $sqlPatients .= " WHERE id = '$searchId'";
}

// Execute SQL statement
$resultPatients = $conn->query($sqlPatients);

// Check if there are any patient records
if ($resultPatients->num_rows > 0) {
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>Patient Records</title>';
    echo '<link rel="stylesheet" href="css/patient.css">';
    echo '</head>';
    echo '<body>';
    include 'header.php';
    echo '<div class="container">';
    
    // Display patient search form with the entered patient ID pre-filled
    echo '<form method="GET" action="">';
    echo '<input type="text" name="search" placeholder="Enter Patient ID" value="' . htmlentities($searchId) . '">';
    echo '<button type="submit">Search</button>';
    echo '</form>';
    
    // Display patient records table only when there are matching records
    if ($resultPatients->num_rows) {
        echo '<br>';
        echo '<form name="historyRecord" method="POST" onsubmit="return validateAssignDoctorForm();">';
        echo '<table>';
        echo '<tr>';
        echo '<th>Select</th>';
        echo '<th>Name</th>';
        echo '<th>Date of Birth</th>';
        echo '<th>Gender</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th>';
        echo '<th>Patient ID</th>';
        echo '<th>History</th>';
        echo '</tr>';
        
        while ($rowPatient = $resultPatients->fetch_assoc()) {
            echo '<tr>';
            echo '<td><input type="checkbox" name="select[]" value="' . $rowPatient['id'] . '"></td>';
            echo '<td>' . $rowPatient['name'] . '</td>';
            echo '<td>' . $rowPatient['dob'] . '</td>';
            echo '<td>' . $rowPatient['gender'] . '</td>';
            echo '<td>' . $rowPatient['email'] . '</td>';
            echo '<td>' . $rowPatient['phone'] . '</td>';
            echo '<td>' . $rowPatient['id'] . '</td>';
            if (isset($rowPatient['History'])) {
                echo '<td>' . $rowPatient['History'] . '</td>';
            } else {
                echo '<td></td>';
            }
            echo '</tr>';
        }
        
        echo '<table>';
        echo '<tr>';
        echo '</tr>';
        echo '</table>';

        // Add the text box and button
        echo '<br>';
        echo '<form method="POST" action="">';
        echo '<label for="history">History:</label>&nbsp;';
        echo '<input type="text" id="history" name="history" style="width: 300px; height: 50px;">';
        echo '<br>';
        echo '<br>';
        echo '<button type="submit" name="Save">Save</button>';
        echo '</form>';
    }
   echo '</div>';
    echo '</body>';
    echo '</html>';
} else {
    // Display error message if no matching patient records are found
    echo 'No matching patient records found.';
}

// Close database connection
$conn->close();
?>