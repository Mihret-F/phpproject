<?php
// Include the database connection file
include('include/connection.php');

// Create SQL SELECT statements
$sqlPatients = "SELECT * FROM patients WHERE status = 'assigned'";

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
    echo '<title>Patient Records</title>';
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
    
    echo '<form name="historyForm" method="POST" action="" onsubmit="return validatePatientHistoryForm();">';
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
        echo '<td>' . $rowPatient['history'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>';

    // Add the text box, patient ID field, and button
    echo '<br>';
    echo '<label for="history">History:</label>&nbsp;';
    echo '<input type="text" id="history" name="history" style="width: 300px; height: 50px;">';
    echo '<input type="hidden" name="patientId" id="patientId">';
    echo '<br>';
    echo '<br>';
    echo '<button type="submit" name="saveHistory">Save</button>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    // Handle form submission
    if (isset($_POST['saveHistory'])) {
        // Check if the 'select' array is defined
        if (isset($_POST['select'])) {
            // Get the selected patient IDs and history value from the form data
            $selectedPatients = $_POST['select'];
            $history = $_POST['history'];
            // Loop through the selected patient IDs and update their history value in the database
            foreach ($selectedPatients as $patientId) {
                $sqlUpdateHistory = "UPDATE patients SET history = '$history' WHERE id = '$patientId'";
                $result = $conn->query($sqlUpdateHistory);
                if (!$result) {
                    echo "Error updating history for patient with ID " . $patientId . ": " . $conn->error;
                }
                else{
                    echo "the patient history is recorded successfully";
                }
            }
        } else {
            echo "Please select at least one patient.";
        }
    }
    echo '</div>';
    echo '</form>';

    echo '<script src="js/search.js"></script>';
    echo '<script src="js/history.js"></script>';
    include 'include/footer.php';
    echo '</body>';
    echo '</html>';
} else {
    echo "No assigned patient records found.";
}

$conn->close();
?>