function validateForm() {
    // Check if at least one checkbox is checked
    var checkboxes = document.getElementsByName("select[]");
    var checked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }
    if (!checked) {
        alert("Please select at least one patient.");
        return false;
    }

    // Check if the radio button for medical test is selected
    var testRadios = document.getElementsByName("test");
    var testChecked = false;
    for (var i = 0; i < testRadios.length; i++) {
        if (testRadios[i].checked) {
            testChecked = true;
            if (testRadios[i].value == "Other") {
                // If 'Other' is selected, check if the 'other_test' field is filled out
                var otherTestField = document.getElementsByName("other_test")[0];
                if (otherTestField.value == "") {
                    alert("Please enter the name of the other test.");
                    return false;
                }
            }
            break;
        }
    }
    if (!testChecked) {
        alert("Please select a medical test type.");
        return false;
    }

    // If all validations pass, submit the form
    return true;
}
