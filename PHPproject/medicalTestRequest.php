<?php
include('include/connection.php');

$sqlPatients = "SELECT * FROM patients WHERE history IS NOT NULL AND history != ''";

// Handle patient search
if(isset($_GET['search'])) {
    $searchId = $_GET['search'];
    // Modify the SQL query to search for the specific patient ID
    $sqlPatients .= " AND id = '$searchId'";
}

// Execute SQL statements
$resultPatients = $conn->query($sqlPatients);

// Check if there are any patient records
if ($resultPatients->num_rows > 0) {
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<title>MedicalTest Request</title>';
    echo '<link rel="stylesheet" href="css/patient.css">';
    echo '</head>';
    echo '<body>';
    include 'include/docHeader.php';

    // Display patient search form
    echo '<div class="container">';
    echo '<form method="GET" action="" onsubmit="return validatePatientSearchForm();">';
    echo '<input type="text" name="search" placeholder="Enter Patient ID">';
    echo '<button type="submit">Search</button>';
    echo '</form>';
    echo '<br>';

    // Display patient records table
    
    echo '<form name="testForm" method="POST" action="" onsubmit="return validateForm();">';
    echo '<table>';
    echo '<tr>';
    echo '<th>Select</th>';
    echo '<th>Name</th>';
    echo '<th>Patient ID</th>';
    echo '<th>History</th>';
    echo '</tr>';
    while ($rowPatient = $resultPatients->fetch_assoc()) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="select[]" value="' . $rowPatient['id'] . '"></td>';
        echo '<td>' . $rowPatient['name'] . '</td>';
        echo '<td>' . $rowPatient['id'] . '</td>';
        echo '<td>' . $rowPatient['history'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>';
    
    // Add radio buttons for medical tests and a text input field for 'Other'
    echo '<br>';
    echo '<label for="test">Select Medical Test:</label><br><br>';
    echo '<input type="radio" name="test" value="X-Ray"> X-Ray<br>';
    echo '<input type="radio" name="test" value="MRI"> MRI<br>';
    echo '<input type="radio" name="test" value="CT-Scan"> CT-Scan<br>';
    echo '<input type="radio" name="test" value="Other"> Other<br><br>';
    echo '<input type="text" name="other_test" placeholder="Enter Test Name"><br><br>';
    echo '<button type="submit" name="submit">Send</button>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    // Handle form submission
    if (isset($_POST['submit'])) {
        // Check if the 'select' array is defined
        if (isset($_POST['select'])) {
            // Get the selected patient IDs and test value from the form data
            $selectedPatients = $_POST['select'];
            $test = $_POST['test'];
            if ($test == "Other") {
                $test = $_POST['other_test'];
            }
        // Loop through the selected patient IDs and update their test value in the database
            foreach ($selectedPatients as $patientId) {
                $sqlInsert = "INSERT INTO medicaltest (patient_id, typeoftest, result) VALUES ('$patientId', '$test', '')";
                
                $result = $conn->query($sqlInsert);
                if (!$result) {
                    echo "Error sending test for patient with ID " . $patientId . ": " . $conn->error;
                } else {
                    echo "The medical test is send successfully for patient with ID " . $patientId . ".";
                }
            }
        } 
        else {
            echo "Please select at least one patient.";
        }
    }
    echo '</div>';
    echo '</form>';

    echo '<script src="js/medicalRequest.js"></script>';
    echo '<script src="js/search.js"></script>';
    include 'include/footer.php';
    echo '</body>';
    echo '</html>';
} else {
    echo "No patient records found with recorded history.";
}

// Close database connection
$conn->close();