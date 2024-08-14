<?php
include('include/connection.php');

$sqlPatients = "SELECT * FROM medicaltest";

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
    echo '<title>medicalTest Result</title>';
    echo '<link rel="stylesheet" href="css/patient.css">';
    echo '</head>';
    echo '<body>';
    include 'include/TechHeader.php';

    // Display patient search form
    echo '<div class="container">';
    echo '<form method="GET" action="" onsubmit="return validatePatientSearchForm();">';
    echo '<input type="text" name="search" placeholder="Enter Patient ID">';
    echo '<button type="submit">Search</button>';
    echo '</form>';
    echo '<br>';

    // Display patient records table only when there are matching records
    echo '<br>';
    echo '<form name="updateTest" method="POST">';
    echo '<table>';
    echo '<tr>';
    echo '<th>Select</th>';
    echo '<th>patient ID</th>';
    echo '<th>Type of Test</th>';
    echo '<th>Result</th>';
    echo '</tr>';
    while ($rowPatient = $resultPatients->fetch_assoc()) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="select[]" value="' . $rowPatient['patient_id'] . '"></td>';
        echo '<td>' . $rowPatient['patient_id'] . '</td>';
        echo '<td>' . $rowPatient['typeoftest'] . '</td>';
        echo '<td><input type="text" name="result[' . $rowPatient['patient_id'] . ']" value="' . $rowPatient['result'] . '"></td>';
        echo '</tr>';
    }    
    echo '</table>';
    echo '<br>';
    echo '<button type="submit">Save Results</button>';
    echo '<br>';
    echo '<br>';
    // Handle form submission
     if (isset($_POST['submit'])) {
        if (isset($_POST['select'])) {
        $selectedPatients = $_POST['select'];
        $results = $_POST['result'];

        // Loop through the selected patients and update their test results in the database
        foreach ($selectedPatients as $patientId) {
            $result = $results[$patientId];
            $sqlUpdate = "UPDATE medicaltest SET result = '$result' WHERE patient_id = '$patientId'";
            $resultUpdate = $conn->query($sqlUpdate);

            if (!$resultUpdate) {
                echo "Error updating test result for patient with ID " . $patientId . ": " . $conn->error;
            } else {
                echo "The test result is recorded successfully for patient with ID " . $patientId . ".";
            }
        } 
    } else {
        echo "Please select at least one patient.";
    }
}
    echo '</form>';
    echo '</div>';

    echo '<script src="js/search.js"></script>';
    include 'include/footer.php';
    echo '</body>';
    echo '</html>';
}
else {
    echo "No patient records found with recorded history.";
}

// Close database connection
$conn->close();