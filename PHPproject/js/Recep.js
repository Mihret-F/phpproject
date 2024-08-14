function validateForm() {
     var name = document.getElementById('name').value;
     var dob = document.getElementById('dob').value;
     var email = document.getElementById('email').value;
     var phone = document.getElementById('phone').value;
    
     if (name == "") {
     alert("Name must be filled out");
     return false;
     }
        if (dob == "") {
     alert("Date of birth must be filled out");
     return false;
     }
        if (email == "") {
     alert("Email must be filled out");
            return false;
     } else {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email address");
                return false;
            }
        }
        if (phone == "") {
     alert("Phone number must be filled out");
            return false;
     } else {
            var phoneRegex = /^[0-9]{3}-[0-9]{3}-[0-9]{4}$/;
            if (!phoneRegex.test(phone)) {
                alert("Invalid phone number. Please use the format 123-456-7890.");
                return false;
            }
        }
    
        return true;
    }