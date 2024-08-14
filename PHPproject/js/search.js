function validatePatientSearchForm() {
  var searchId = document.getElementsByName("search")[0].value;
  if (searchId == "") {
    alert("Please enter a patient ID.");
    return false;
  }
  return true;
}
