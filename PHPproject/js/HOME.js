function validateForm() {
    var userType = document.getElementById("user-type").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
  
    if (userType == "") 
    {
      alert("Please select a user type");
      return false;
    }
    if (username == "") 
    {
      alert("Please enter your username");
      return false;
    }
  
    if (password == "") {
      alert("Please enter your password");
      return false;
    }
  }