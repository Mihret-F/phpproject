function validatePatientHistoryForm() {
  var selectedPatients = document.getElementsByName("select[]");
  var history = document.getElementById("history").value;
  if (selectedPatients.length == 0) {
    alert("Please select at least one patient.");
    return false;
  }
  if (history.trim() == "") {
    alert("Please enter a patient history.");
    return false;
  }
  return true;
}