<?php
include('include/connection.php');

$sqlPatients = "SELECT * FROM medicaltest";

// Handle patient search
if(isset($_GET['search'])) {
    $searchId = $_GET['search'];
    // Modify the SQL query to search for the specific patient ID
    $sqlPatients .= " AND patient_id = '$searchId'";
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
    include 'include/docHeader.php';

    // Display patient search form
    echo '<div class="container">';
    echo '<form method="GET" action="" onsubmit="return validatePatientSearchForm();">';
    echo '<input type="text" name="search" placeholder="Enter Patient ID">';
    echo '<button type="submit">Search</button>';
    echo '</form>';
    echo '<br>';

    // Display patient records table only when there are matching records
    if ($resultPatients->num_rows) {
        echo '<br>';
        echo '<form name="updateTest" method="POST">';
        echo '<table>';
        echo '<tr>';
        echo '<th>patient ID</th>';
        echo '<th>Type of Test</th>';
        echo '<th>Result</th>';
        echo '</tr>';
        while ($rowPatient = $resultPatients->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowPatient['patient_id'] . '</td>';
            echo '<td>' . $rowPatient['typeoftest'] . '</td>';
            echo '<td>' . $rowPatient['result'] . '</td>';
            echo '</tr>';
        }    
        echo '</table>';
    echo '</div>';
    echo '</form>';

    echo '<script src="js/search.js"></script>';
    include 'include/footer.php';
    echo '</body>';
    echo '</html>';
}
}
else {
    echo "No patient records found with recorded history.";
}
$conn->close();