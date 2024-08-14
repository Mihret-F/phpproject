<?php
// Include the database connection file
include('include/connection.php');
// Create SQL SELECT statements
$sqlPatients = "SELECT * FROM patients";
$sqlDoctors = "SELECT * FROM staff_members WHERE user_type = 'doctor'";

// Handle patient search
if(isset($_GET['search'])) {
    $searchId = $_GET['search'];
    // Modify the SQL query to search for the specific patient ID
    $sqlPatients .= " WHERE id = '$searchId'";
  }
// Execute SQL statements
$resultPatients = $conn->query($sqlPatients);
$resultDoctors = $conn->query($sqlDoctors);
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
    include 'include/assistHeader.php';

 // Display patient search form
    echo '<div class="container">';
    echo '<form method="GET" action="" onsubmit="return validatePatientSearchForm();">';
    echo '<input type="text" name="search" placeholder="Enter Patient ID">';
    echo '<button type="submit">Search</button>';
    echo '</form>';
    echo '<br>'; 
// Display patient records table

    echo '<form name="assignDoctorForm" method="POST" action="" onsubmit="return validateAssignDoctorForm();">';
    echo '<table>';
    echo '<tr>';
    echo '<th>Select</th>';
    echo '<th>Name</th>';
    echo '<th>Date of Birth</th>';
    echo '<th>Gender</th>';
    echo '<th>Email</th>';
    echo '<th>Phone</th>';
    echo '<th>Patient ID</th>';
    echo '<th>Status</th>';
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
        echo '<td>' . $rowPatient['status'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>';
    // Display assign doctor form for selected patients
    echo '<select name="doctor_id" class="select-doc">';
    // Display doctors in combo box
    echo '<option value="">-- Select Doctor --</option>';
    while ($rowDoctor = $resultDoctors->fetch_assoc()) {
        echo '<option value="' . $rowDoctor['id'] . '">' . $rowDoctor['name'] . '</option>';
    }
    echo '</select>';
    echo '<br>';
    echo '<br>';
    
    echo '<button type="submit" name="assign">Assign</button>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
    if (isset($_POST['assign'])) {
        if (isset($_POST['doctor_id']) && !empty($_POST['doctor_id'])) {
          if (isset($_POST['select']) && is_array($_POST['select'])) {
            foreach ($_POST['select'] as $patientId) {
              
              // Check if the patient is already assigned to a doctor
              $checkSql = "SELECT status FROM patients WHERE id = '$patientId'";
              $result = $conn->query($checkSql);
      
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
      
                if ($row['status'] == 'assigned') {
                  echo "Patient with ID $patientId is already assigned to a doctor.";
                } 
                // Assign the selected doctor to the patient with the given ID
                else {
                  $doctorId = $_POST['doctor_id'];
                  $sql = "UPDATE patients SET status = 'assigned' WHERE id = '$patientId'";
                  if ($conn->query($sql) == TRUE) {
                    echo "Doctor assigned successfully.";
                  } else {
                    echo "Error assigning doctor: " . $conn->error;
                  }
                }
              }
            }
          } else {
            echo "Please select at least one patient to assign a doctor to.";
          }
        } else {
          echo "Please select a doctor to assign to the selected patient(s).";
        }
      }
    } else {
        echo "No patient records found.";
    }
    echo '</div>';
    echo '</form>';

   echo '<script src="js/phy_assist.js"></script>';
   echo '<script src="js/search.js"></script>';
    include 'include/footer.php';
    echo '</body>';
    echo '</html>';

// Close database connection
$conn->close();
?>