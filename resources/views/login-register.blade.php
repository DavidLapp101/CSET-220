<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggle() {
            if ($("#account-form-btn").text() == "Login") {
                $("#login-div").slideDown();
                // $("#login-div").slideDown({
                //     start: function () {
                //         $(this).css("display", "flex");
                //     }
                // });
                $("#register-div").slideUp();
                $("#account-form-btn").text("Register");
            } 
            else {
                $("#login-div").slideUp();
                $("#register-div").slideDown();
                // $("#register-div").slideDown({
                //     start: function () {
                //         $(this).css("display", "flex");
                //     }
                // });
                $("#account-form-btn").text("Login");
            }
        }

        function checkPatient(value) {
            if (value == 5) {
                $(".patient-only").each(function() {
                    $(this).prop("disabled", false);
                    $(this).prop("required", true);
                })
            }
            else {
                $(".patient-only").each(function() {
                    $(this).prop("disabled", true);
                    $(this).prop("required", false);
                    $(this).val("");
                });
            }
        }
    </script>
</head>
<body id="account-body">
    <div id="account-container">
        <button id="account-form-btn" onclick="toggle()">Register</button>
        <?php
            if (isset($_POST["login-info"])) {
                if ($_POST["login-info"] == "incorrect") {
                    echo ("<p style='color: red;'>Incorrect Information</p>");
                }
                else if ($_POST["login-info"] == "pending") {
                    echo ("<p style='color: red;'>Your account has not been approved</p>");
                }
            }
        ?>
        <div id="login-div" class="account-div">
            <form id="login-form" class="account-form" action="/api/login" method="post">
                <h3>Login</h3>
                <input type="text" name="login-email" id="login-email" placeholder="Email">
                <input type="text" name="login-pass" id="login-pass" placeholder="Password">
                <input type="submit" name="Submit">
            </form>
        </div>
        
        <div id="register-div" class="account-div">
            <form id="register-form" class="account-form" action="/api/register" method="post">
                <h3>Register</h3>
                <div id="register-inputs-div">
                    <select name="reg-role" id="reg-role" onchange="checkPatient(this.value)" required>
                        <option value="" disabled selected>Role:</option>
                        <option value=1>Admin</option>
                        <option value=2>Supervisor</option>
                        <option value=3>Doctor</option>
                        <option value=4>Caregiver</option>
                        <option value=5>Patient</option>
                        <option value=6>Family Member</option>
                    </select>
                    <input type="text" name="reg-name" id="reg-name" placeholder="Full Name" required>
                    <input type="text" name="reg-email" id="reg-email" placeholder="Email" required>
                    <input type="number" name="reg-phone" id="reg-phone" placeholder="Phone" required>
                    <input type="text" name="reg-pass" id="reg-pass" placeholder="Password" required>
                    <input type="date" name="reg-dob" id="reg-dob" required>
                </div>
                <div id="patient-only-div">
                    <h4 style="margin: 5.5px 0px">Patients Only</h4>
                    <input type="text" name="reg-code" id="reg-code" class="patient-only" placeholder="Family Code" disabled>
                    <input type="text" name="reg-contact-phone" id="reg-contact" class="patient-only" placeholder="Emergency Contact Phone" disabled>
                    <input type="text" name="reg-contact-name" id="reg-contact" class="patient-only" placeholder="Emergency Contact Name" disabled>
                    <input type="text" name="reg-relation" id="reg-relation" class="patient-only" placeholder="Contact Relation" disabled>
                </div>
                <input type="submit" name="submit" style="clear: both; width: 95%">
            </form>
        </div>
    </div>
    
    
</body>
</html>