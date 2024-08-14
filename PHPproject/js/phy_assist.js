//  JavaScript validation for assign doctor form
function validateAssignDoctorForm() {
 var doctorId = document.forms["assignDoctorForm"]["doctor_id"].value;
  if (doctorId == "") {
    alert("Please select a Doctor.");
    return false;
 }
  var checkboxes = document.querySelectorAll('input[name="select[]"]');
  var checked = false;
  checkboxes.forEach(function(checkbox) {
    if (checkbox.checked) {
      checked = true;
    }
  });
 if (!checked) {
    alert("Please select at least one patient.");
    return false;
  }
}