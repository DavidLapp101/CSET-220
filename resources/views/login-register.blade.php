<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggle() {
            if ($("#account-form-btn").text() == "Login") {
                $("#login-div").slideDown();
                $("#register-div").slideUp();
                $("#account-form-btn").text("Register");
            } 
            else {
                $("#login-div").slideUp();
                $("#register-div").slideDown();
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
<body>
<div id="account-body">
    <div id="account-container">
        <button id="account-form-btn" onclick="toggle()">Register</button>
        <div id="login-div" class="account-div">
            <form id="login-form" class="account-form" action="/api/login" method="post">
                <h3>Login</h3>
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
                <input type="text" name="login-email" id="login-email" placeholder="Email">
                <input type="password" name="login-pass" id="login-pass" placeholder="Password">
                <input type="submit" name="Submit">
            </form>
        </div>
        
        <div id="register-div" class="account-div">
            <form id="register-form" class="account-form" action="/api/register" method="post">
                <h3>Register</h3>
                <div id="register-inputs-div">
                    <select name="reg-role" id="reg-role" onchange="checkPatient(this.value)" required>
                        <option value="" disabled selected>Role:</option>
                        <?php
                        use App\Models\Role;
                        $roles = json_decode(json_encode(Role::all()), true);
                            for ($i=0; $i<count($roles); $i++) {
                                echo "<option value='".$roles[$i]["roleID"]."'>".$roles[$i]["roleName"]."</option>";
                            }
                        ?>
                    </select>
                    <input type="text" name="reg-name" id="reg-name" placeholder="Full Name" required>
                    <input type="text" name="reg-email" id="reg-email" placeholder="Email" required>
                    <input type="number" name="reg-phone" id="reg-phone" placeholder="Phone" required>
                    <input type="password" name="reg-pass" id="reg-pass" placeholder="Password" required>
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
    
</div>

</body>

<div class="container">
    <div class="row-flex">
      <div class="flex-column-form">
        <h3>
          Booking
        </h3>
      <form class="media-centered">
          <div class="form-group">
            <p>
              Please leave your number we will call to make a reservation
            </p>
            <input type="name" class="form-control" id="exampleInputName1" aria-describedby="nameHelp" placeholder="Enter your name">
          </div>
          <div class="form-group">
            <input type="number" class="form-control" id="exampleInputphoneNumber1" placeholder="Enter your phone number">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
      <div class="opening-time">
        <h3>
          Opening times
        </h3>
        <p>
         <span>Monday—Thursday: 08:00 — 5:00</span> 
         <span>Friday—Saturday: 09:00 — 4:00 </span>
         <span>Sunday: 8:00 — 12:00</span>
        </p>
      </div>
      <div class="contact-adress">
        <h3>
          Contact
        </h3>
        <p>
          <span>717-456-9807  - 717-003-0908</span>
          <h3>
            Address
          </h3>
          <span>1100 Orange Street Lancaster,PA</span>
        </p>
      </div>
    </div>
    </div>

    <footer>
        <div class="flex container">
            <div class="footer-about">
                
            </div>
      
            <div class="footer-quick-links">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="#">Enrollment</a></li>
                    <li><a href="#">Documents and Forms</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
      
            <div class="footer-subscribe">
                <h5>Subscribe to our Newsletter</h5>
                <div id="subscribe-container">
                    <input type="text" placeholder="Enter Email" />
                    <button class="right-rounded">Send</button>
                </div>
      
                <h5 class="follow-us">Follow Us</h5>
            </div>
        </div>
      
        <small>
            Copyright &copy; 2021 All rights reserved | Design by US</a>
        </small>
      </footer>


</html>